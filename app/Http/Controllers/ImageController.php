<?php namespace App\Http\Controllers;

use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $type = 'image', $filename )
    {
        if ($type === 'cache') {
            $path = storage_path('app') . '/cache/' . $filename;
        } else if ($type === 'uimg') {
            $path = storage_path('app') . '/user/' . $filename;
        } else {
            $path = storage_path('app') . '/images/' . str_plural($type) . '/' . $filename;
        }


        if(!\File::exists($path)) abort(404);

        $file = \File::get($path);
        $type = \File::mimeType($path);

        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function thumb( $type, $w, $h, $filename ) {
        $file = storage_path('app') . '/images/' . str_plural($type) . '/' . $filename;
        $path = storage_path('app') . '/thumbs/thumb_' . $w . '_' . $h . '_' . str_plural($type) . '_' . $filename;

        if(!\File::exists($file)) abort(404);
        if(\File::exists($path)) {
            $f = \File::get($path);
            $type = \File::mimeType($path);

            $response = \Response::make($f, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

        // create an image manager instance with favored driver
        $manager = new ImageManager(/*array('driver' => 'imagick')*/);
        // to finally create image instances
        $mm     = $manager->make($file);
        $width  = $mm->getWidth();
        $height = $mm->getHeight();
        if( $w > $height && $h > $height ) {
            if(\File::exists($file)) {
                $f = \File::get($file);
                $type = \File::mimeType($file);

                $response = \Response::make($f, 200);
                $response->header("Content-Type", $type);

                return $response;
            }
        }
        if($width > $height) {
            $percent = $height / $width;
            $h = $percent * $h;
        } else {
            $percent = $width / $height;
            $w = $percent * $w;
        }
        $image = $mm->resize($w, $h);
        $image->save($path, 60);

        return $image->response('png');

    }

}
