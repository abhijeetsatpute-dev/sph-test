<?php

namespace Drupal\ws_qr_code\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Provide QrCode Service.
 */
class QrCode {

  /**
   * Returns QR code image data.
   *
   * @return string
   *   Generated Base 64 QR
   */
  public function getQrCode(string $url) {
    if ($url == NULL) {
      return NULL;
    }
    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($url)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size(300)
      ->margin(10)
      ->build();
    return $result->getDataUri();
  }

}
