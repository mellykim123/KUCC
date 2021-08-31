<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body onload="lodaDoc()">
  <h2 id="gubun"></h2>


  <?php
  
  $ch = curl_init();
  $url = 'http://openapi.data.go.kr/openapi/service/rest/Covid19/getCovid19SidoInfStateJson'; /*URL*/
  $queryParams = '?' . urlencode('ServiceKey') . '=ARyzcNUgwHv4UkTLHubzf1ziDn9XZ6jO6w%2FoI%2B%2BND%2BtxGVsj5f%2FsVzIMKi6Uxcgdc8s%2B2n7V6UZAnq4vUWy58A%3D%3D'; /*Service Key*/
  
  $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
  $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('10'); /**/
  $queryParams .= '&' . urlencode('startCreateDt') . '=' . urlencode('20210816'); /**/
  $queryParams .= '&' . urlencode('endCreateDt') . '=' . urlencode('20210816'); /**/

  curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  
  $response = curl_exec($ch);
  curl_close($ch);

  $object = simplexml_load_string($response);

  // 오늘 확진자
  $Today_def = array();
  // 지역 총 확진자
  $Total_def = array();

  // 사망자
  $Death_cnt = array();

  // 완치자
  $Total_care = array();

  // 10만명당 확진자
  $qurRate = array();


  $items = $object->body->items->item;
  $i = 0;

  foreach ($items as $item) {
    $Today_def[$i] = $item->incDec;
    $Total_def[$i] = $item->defCnt;
    $gubun_arr[$i] = $item->gubun;
    $Death_cnt[$i] = $item->deathCnt;

    $Total_care[$i] = $item->isolClearCnt;

    $qurRate[$i] = $item->qurRate;
    $i += 1;
  }

  //echo $suggest0;
  ?>





  <table>
    <tr>

      <?php

      $j = 0;
      while ($j < count($gubun_arr))
      {
        echo "<td>{$gubun_arr[$j]}</td>";
        $j++;
      }


      ?>

    </tr>
    <tr>
      <?php

      $j = 0;
      while ($j < count($Today_def)) {
        echo "<td>{$Total_def[$j]}</td>";
        $j++;
      }


      ?>
    </tr>

  </table>

</body>

</html>