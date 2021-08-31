<?php
  
  
  $ch = curl_init();
  $url = 'http://openapi.data.go.kr/openapi/service/rest/Covid19/getCovid19SidoInfStateJson'; /*URL*/
  $queryParams = '?' . urlencode('ServiceKey') . '=ARyzcNUgwHv4UkTLHubzf1ziDn9XZ6jO6w%2FoI%2B%2BND%2BtxGVsj5f%2FsVzIMKi6Uxcgdc8s%2B2n7V6UZAnq4vUWy58A%3D%3D'; /*Service Key*/
  
  // 오늘 거 받아오기
  $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
  $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('10'); /**/
  $queryParams .= '&' . urlencode('startCreateDt') . '=' . urlencode('20210815'); /**/
  $queryParams .= '&' . urlencode('endCreateDt') . '=' . urlencode('20210816'); /**/

  curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  $response = curl_exec($ch);
  curl_close($ch);
  $object = simplexml_load_string($response);

  $gubun_arr = array();

  // 오늘 확진자
  $Today_def = array();
  $Today_def_change = array();
  
  // 지역 총 확진자
  $Total_def = array();
  $Total_def_change = array();
  
  // 사망자
  $Death_cnt = array();
  $Death_cnt_change = array();
  
  // 완치자
  $Total_care = array();
  $Total_care_change = array();

  // 10만명당 확진자
  $qurRate = array();


  $items = $object->body->items->item;

  $i = 0;

  foreach ($items as $item) {
    if($i < 19){
    $Today_def[$i] = $item->incDec; // 오늘
    $Total_def[$i] = $item->defCnt; // 총
    $gubun_arr[$i] = $item->gubun; // 지역명
    $Death_cnt[$i] = $item->deathCnt; // 사망자

    $Total_care[$i] = $item->isolClearCnt; //완치자

    $qurRate[$i] = $item->qurRate; //10만명당
    $i += 1;
    }
    else{
      $Today_def_change[$i-19] = ($item->incDec - $Today_def[$i-19]);
      $Total_def_change[$i-19] = ($item->defCnt - $Total_def[$i-19]);
      $Death_cnt_change[$i-19] = ($item->deathCnt - $Death_cnt[$i-19]);
      $Total_care_change[$i-19] = ($item->isolClearCnt - $Total_care[$i-19]);
      $i +=1;

    }
  }
  
  
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>코로나 라이브 | 실시간 전국</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="navigator">
    <div class="navigator_banner">
      <div class="mail_icon">
        <i class="fas fa-location-arrow"></i>
      </div>
      <div class="navigator_title">
        <a href="./index.html">
          <span id="title_Corona">Corona</span><span id="title_Live">Live</span>
        </a>
      </div>
      <div class="navigator_menu">
        <i class="fas fa-bars"></i>
      </div>
    </div>
    <div class="navigator_section">
      <div class="navigator_subtitle navigator_selected">
        <span>국내</span>
      </div>
      <div class="navigator_subtitle">
        <span>해외</span>
      </div>
      <div class="navigator_subtitle">
        <span>백신</span>
      </div>
      <div class="navigator_subtitle">
        <span>거리두기</span>
      </div>
    </div>
  </div>

  <div class="total-result">
    <div class="smallscreen-result">
      <div class="infected-patients">
        <span>확진자</span>
        <span> 207,406 </span>
        <span> 1,704 </span>
      </div>
      <div class="deceased-patients">
        <span>사망자</span>
        <span> 2,113 </span>
        <span> 4 <span>
      </div>
      <div class="cured-patients">
        <span>완치자</span>
        <span> 182,052 </span>
        <span> 1,333 </span>
      </div>
      <div class="tested-patients">
        <span>검사자</span>
        <span> 11,951,652 </span>
        <span> 43,216 </span>
      </div>
    </div>
    <div class="bigscreen-result">
      <div class="bigscreen_main">
        <div class="bigscreen_upper">
          <div class="bigscreen_big">
            <div class="bigscreen_today_title">오늘 확진자수</div>
            <div class="bigscreen_today">1,485명</div>
          </div>
          <div class="bisgsceen_small">
          <div class="bigscreen_column_1">
            <div class="bigscreen_yesterday_title">vs 어제</div>
            <div class="bigscreen_pastweek_title">vs 1주전</div>
          </div>
          <div class="bigscreen_column_2">
            <div class="bigscreen_yesterday">56 ⬇︎</div>
            <div class="bigscreen_pastweek">95 ⬆︎</div>
          </div>
          <div class="bigscreen_column_1">
            <div class="bigscreen_pasttwoweek_title">vs 2주전</div>
            <div class="bigscreen_pastmonth_title">vs 1달전</div>
          </div>
          <div class="bigscreen_column_2">
            <div class="bigscreen_pasttwoweek">383 ⬆︎</div>
            <div class="bigscreen_pastmonth">317 ⬆︎</div>
          </div>
          </div>
        </div>
      </div>
      <div class="bigscreen_sub">
        <div class="bigscreen_time">
          <i class="fas fa-bell"></i><div>37분 전</div></div>
        <div class="bigscreen_title"><div class = "bold">경기 파주시</div> 2명 추가 확진</div>
        <div class="bigscreen_img"><i class="fas fa-chevron-down"></i></div>
      </div>
    </div>
    <div class="graph-picture">
      <div class="select-categories">
        <select name='data-categories1'>
          <option value='infected'> 확진자 </option>
          <option value='deceased'>사망자</option>
          <option value='tested'>검사자</option>
          <option value="infected-rated">확진율</option>
          <option value="cured">완치자</option>
        </select>
        <select name='data-categories2'>
          <option value='real-time'> 실시간 </option>
          <option value='daily'>일별</option>
          <option value='weekly'>주별</option>
          <option value="monthly">월별</option>
          <option value="total">누적</option>
        </select>
        <select name='data-categories3'>
          <option value='yesterday'> 어제 </option>
          <option value='oneweek-ago'>1주전</option>
          <option value='twoweeks-ago'>2주전</option>
          <option value="onemonth-ago">1달전</option>
        </select>

      </div>
    </div>
    <button class="add-graph">
      + 그래프 추가
    </button>
    <div class="graph-number">
      그래프 수치
    </div>
    <div class="total_chart">
      <div class="total_chart_navigator"></div>
      <div class="total_chart_table">
        <table>
          <tr class="table_head">
            <th>지역</th>
            <th>오늘 확진자</th>
            <th>총 확진자</th>
            <th>총 사망자</th>
            <th>총 완치자</th>
            <th>10만명당 확진자</th>
          </tr>
          <?php
          
          
          $j = 0;
          while ($j < count($gubun_arr))
          
          {
            echo "<tr>";
            echo "<td>{$gubun_arr[$j]}</td>";
            
            
            
            
            
            echo "<td>
            <span>{$Today_def[$j]}</span>
            <span class='Today_def_change_{$j}'>
            {$Today_def_change[$j]}
            </span>
            </td>";

            echo "<td><span>{$Total_def[$j]}</span><span>{$Total_def_change[$j]}</span></td>";
            echo "<td><span>{$Death_cnt[$j]}</span><span>{$Death_cnt_change[$j]}</span></td>";
            echo "<td><span>{$Total_care[$j]}</span><span>{$Total_care_change[$j]}</span></td>";
            echo "<td>{$qurRate[$j]}</td>";
            $j++;
            echo "</tr>";
          
          
          
          
          }

          $j=0;

          while ($j < count($gubun_arr))
          {
            echo "<script>
            if({$Today_def_change[$j]}>0)
            {document.querySelector('.Today_def_change_{$j}').style.backgroundColor='red';
          }
            else if({$Today_def_change[$j]}<0){
            document.querySelector('.Today_def_change_{$j}').style.backgroundColor='blue';
            }
            else{
              document.querySelector('.Today_def_change_{$j}').style.backgroundColor='green';
            }
            </script>";
            $j++;
          }
          
          ?>
        </table>
      </div>
      <script>
        `Today_def_change_${i}`
      </script>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/6478f529f2.js" crossorigin="anonymous">
  </script>
</body>

</html>

