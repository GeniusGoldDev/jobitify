import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/common/css/combotree.css',
                'public/common/css/bootstrap.min.css',
                'public/css/feather-icons.css',
                'public/css/fontawesome/all.min.css',
                'public/common/css/select2.min.css',
                'public/common/css/jquery.mCustomScrollbar.min.css',
                'public/common/css/jquery-confirm.min.css',
                'public/css/nouislider.min.css',
                'public/css/rangeslider.css',
                'public/css/fontawesome/nunito-font.css',
                'public/admin/css/themify-icons.css',
                'public/pagebuilder/css/venobox.min.css',
                'public/common/css/croppie.css',
                'public/pagebuilder/css/swiper-bundle.min.css',
                'public/pagebuilder/css/splide.min.css',
                'public/pagebuilder/css/tinymce/tinymce.css',
                'public/common/js/jquery-confirm.min.js',
            ],
            refresh: true,
        }),
    ],
});
