<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
    <?= $this->include('frontend/sections/tentang') ?>
    <?= $this->include('frontend/sections/visi-misi') ?>
    <?= $this->include('frontend/sections/organisasi') ?>
    <?= $this->include('frontend/sections/program') ?>
    <?= $this->include('frontend/sections/kegiatan') ?>
    <?= $this->include('frontend/sections/prestasi') ?>
    <?= $this->include('frontend/sections/galeri') ?>
    <?= $this->include('frontend/sections/berita') ?>
    <?= $this->include('frontend/sections/aspirasi') ?>
    <?= $this->include('frontend/sections/pertanyaan-umum') ?>
<?= $this->endSection() ?>