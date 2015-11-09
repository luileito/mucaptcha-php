<?php
/**
 * mucaptcha PHP lib. Procedural style.
 * @author Luis A. Leiva
 * @version 1.1.0
 */
function mucaptcha_verify($secret, $referer, $challenge, $strokes)
{
  if (empty($secret)) {
    throw new Exception("No secret key provided.");
  }
  if (empty($referer)) {
    throw new Exception("No referer provided.");
  }

  $url = 'https://api.mucaptcha.com/v1/verify';
  $fields = array(
    'secret'    => $secret,
    'referer'   => $referer,
    'challenge' => $challenge,
    'strokes'   => $strokes,
  );
  $response = mucaptcha_post_request($url, $fields);
  return json_decode($response);
}

// TODO: Provide alt. methods for servers without curl support.
function mucaptcha_post_request($url, $data)
{
  $options = array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_SSL_VERIFYPEER => TRUE,
    CURLOPT_HEADER         => FALSE,
    CURLOPT_POST           => TRUE,
    CURLOPT_POSTFIELDS     => $data,
  );
  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  curl_close($ch);
  return $content;
}
?>
