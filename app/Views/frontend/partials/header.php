<?php
$organization = config('Organization');
$isLanding    = $isLanding ?? false;
?>
<!DOCTYPE html>
<html lang="id">
	<head>
		<title><?= esc($title ?? $organization->name . ' - ' . $organization->fullName) ?></title>
		<meta charset="utf-8" />
		<meta name="description" content="<?= esc($metaDescription ?? $organization->fullName . ' ' . $organization->university . '. ' . $organization->tagline) ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="id_ID" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?= esc($title ?? $organization->name, 'attr') ?>" />
		<meta property="og:site_name" content="<?= esc($organization->name, 'attr') ?>" />
		<link rel="shortcut icon" href="<?= esc($organization->faviconUrl(), 'attr') ?>" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/frontend-custom.css?v=20261124-3') ?>" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<body id="kt_body" class="bg-body position-relative"<?= $isLanding ? ' data-bs-spy="scroll" data-bs-target="#kt_landing_menu"' : '' ?>>
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
