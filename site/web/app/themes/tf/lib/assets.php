<?php
namespace Roots\Sage\Assets;

/**
 * Get paths for assets
 */
class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename) {
  $dist_path = get_template_directory_uri() . '/dist/';
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_template_directory() . '/dist/' . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

function get_responsive_image($imageObject, $title, $cssClass, $desktopImageSize1x, $desktopImageSize2x, $tabletLandscapeImageSize1x, $tabletLandscapeImageSize2x, $tabletPortraitImageSize1x, $tabletPortraitImageSize2x, $mobileImageSize1x, $mobileImageSize2x, $defaultWidth = '100%') {
    return '<picture class="'.$cssClass.'">
                <source media="(min-width: 992px)" srcset="'.get_image_size_url($imageObject, $desktopImageSize1x).', '.get_image_size_url($imageObject, $desktopImageSize2x).' 2x">
                <source media="(min-width: 768px) and (max-width: 991px)" srcset="'.get_image_size_url($imageObject, $tabletLandscapeImageSize1x).', '.get_image_size_url($imageObject, $tabletLandscapeImageSize2x).' 2x">
                <source media="(min-width: 480px) and (max-width: 767px)" srcset="'.get_image_size_url($imageObject, $tabletPortraitImageSize1x).', '.get_image_size_url($imageObject, $tabletPortraitImageSize2x).' 2x">
                <source media="(max-width: 479px)" srcset="'.get_image_size_url($imageObject, $mobileImageSize1x).', '.get_image_size_url($imageObject, $mobileImageSize2x).' 2x">
                <img src="'.get_image_size_url($imageObject, $desktopImageSize1x).'" srcset="'.get_image_size_url($imageObject, $desktopImageSize1x).', '.get_image_size_url($imageObject, $desktopImageSize2x).' 2x" alt="'.$title.'" width="'.$defaultWidth.'">
            </picture>';
}

function get_responsive_image_bg_styles($targetSelector, $imageObject, $desktopImageSize1x, $desktopImageSize2x, $tabletLandscapeImageSize1x, $tabletLandscapeImageSize2x, $tabletPortraitImageSize1x, $tabletPortraitImageSize2x, $mobileImageSize1x, $mobileImageSize2x) {
    $output = '<style>
                '.get_background_style($targetSelector, $imageObject, $mobileImageSize1x).'
                @media (max-width: 479px) and (min-resolution: 192dpi) {'.get_background_style($targetSelector, $imageObject, $mobileImageSize2x).'}
                @media (min-width: 480px) and (max-width: 767px) and (max-resolution: 191dpi) {'.get_background_style($targetSelector, $imageObject, $tabletPortraitImageSize1x).'}
                @media (min-width: 480px) and (max-width: 767px) and (min-resolution: 192dpi) {'.get_background_style($targetSelector, $imageObject, $tabletPortraitImageSize2x).'}
                @media (min-width: 768px) and (max-width: 991px) and (max-resolution: 191dpi) {'.get_background_style($targetSelector, $imageObject, $tabletLandscapeImageSize1x).'}
                @media (min-width: 768px) and (max-width: 991px) and (min-resolution: 192dpi) {'.get_background_style($targetSelector, $imageObject, $tabletLandscapeImageSize2x).'}
                @media (min-width: 992px) and (max-resolution: 191dpi) {'.get_background_style($targetSelector, $imageObject, $desktopImageSize1x).'}
                @media (min-width: 992px) and (min-resolution: 192dpi) {'.get_background_style($targetSelector, $imageObject, $desktopImageSize2x).'}
                @media (min-width: 1440px) {'.get_background_style($targetSelector, $imageObject, $desktopImageSize2x).'}
            </style>
    ';

    return $output;
}

function get_background_style($targetSelector, $imageObject, $imageSize) {
    return $targetSelector.' { background-image: url('.get_image_size_url($imageObject, $imageSize).'); }';
}

function get_image_size_url($imageObject, $imageSize) {
	$imageURL = '';

    //The image object could be the image ID from a post or the image object for an Advanced Custom Fields image field.
    if (is_numeric($imageObject)):
        $imageURL = wp_get_attachment_image_src($imageObject, $imageSize)[0];
	else:
		// var_dump($imageObject);
        if ($imageSize == 'full'):
            $imageURL = $imageObject['url'];
        elseif (array_key_exists('sizes', $imageObject) && array_key_exists($imageSize, $imageObject['sizes'])):
            $imageURL = $imageObject['sizes'][$imageSize];
        endif;
    endif;

    return $imageURL;
}
