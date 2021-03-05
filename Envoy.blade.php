@servers(['web' => 'ec2-user@52.31.236.55'])

@task('list', ['on' => 'web'])
ls -l
@endtask

@setup
    $repository = 'git@gitlab.com:mohammed.bauomey/raneen.git';
    $releases_dir = '/var/www/html/website/releases';
    $app_dir = '/var/www/html/website';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard {{ $commit }}
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-scripts -q -o
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env
    ln -nfs {{ $app_dir }}/node_modules {{ $new_release_dir }}/node_modules

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current

@endtask

@task('npm')
    echo "NPM"
    ln -nfs {{ $app_dir }}/node_modules {{ $new_release_dir }}/node_modules
    cd {{ $new_release_dir }}
    npm run watch
@endtask

@task('clean')
    echo "CLEAN!!"
    find {{$releases_dir}} -mindepth 1 -maxdepth 1 -type d -not -name {{$release}} \
    -exec rm -rf '{}' \;

    sudo chmod -R 777 {{ $releases_dir }}
@endtask

@story('deploy')
    clone_repository
    run_composer
    update_symlinks
    clean
@endstory
