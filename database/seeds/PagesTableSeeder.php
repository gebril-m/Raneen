<?php

use App\Language;
use App\Page;
use App\PageTranslation;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar_name = ['معلومات عنا' , 'اتصل بنا','سياسة المستخدم','اسئلة شائعة','سياسات الشحن'];
        $en_name = ['About us' , 'Contact us','Terms & Conditions','FAQ','Shipment policy'];
        $body = "<!-- about section start -->
<section class=\"about-page section-big-py-space\">
    <div class=\"custom-container\">
        <div class=\"row\">
            <div class=\"col-lg-6\">
                <div class=\"banner-section\"><img src=\"../assets/images/blog/1.jpg\" class=\"img-fluid   w-100\" alt=\"\"></div>
            </div>
            <div class=\"col-lg-6\">
                <h4>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</h4>
                <p class=\"mb-2\"> Sed ut perspiciatis unde omnis iste natus <b>error sit</b> voluptatem accusantium doloremque laudantium,</p>
                <p class=\"mb-2\"> On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>
                <p class=\"mb-2\">  These <b>cases</b> are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our</p>
                <p> being able to do what we like best, every pleasure is to be <b>welcomed</b> and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid <b>worse</b> pains.</p>
            </div>
        </div>
    </div>
</section>
<!-- about section end -->
";

        $lan = Language::all();
        for($i =0 ; $i < count($ar_name);$i++){
        $page = new Page();
        $page->is_active = 1  ;
        $page->show_footer =  1  ;
        $page->show_header =  1  ;
        $page->save();
        foreach($lan as $local){
                $pageTran = new PageTranslation();
                $pageTran->page_id = $page->id;
                $pageTran->name = ${$local->locale."_name"}[$i];
                $pageTran->slug = trim(str_replace(' ',"-",$pageTran->name));
                $pageTran->body = $body;
                $pageTran->meta_title = "TEST";
                $pageTran->meta_keywords = "TEST";
                $pageTran->meta_description = "TEST";
                $pageTran->locale = $local->locale;
                $pageTran->save();
            }
        }

    }
}
