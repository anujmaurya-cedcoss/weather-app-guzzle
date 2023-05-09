<?php
use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;

class IndexController extends Controller
{
  public function indexAction()
  {
    // redirected to view
  }
  public function weatherAction()
  {
    $city = $_POST['city'];
    $type = $_POST['type'];

    if ($type == '/current.json') {
      $this->response->redirect('index/current?city=' . $city . '&&type=' . $type);
    }
    if ($type == '/forecast.json') {
      $this->response->redirect('index/forecast?city=' . $city . '&&type=' . $type);
    }
    if ($type == '/history.json') {
      $this->response->redirect('index/forecast?city=' . $city . '&&type=' . $type);
    }
    if ($type == '/timezone.json') {
      $this->response->redirect('index/timezone?city=' . $city . '&&type=' . $type);
    }
    if ($type == '/sports.json') {
      $this->response->redirect('index/sports?city=' . $city . '&&type=' . $type);
    }
    if ($type == '/astronomy.json') {
      $this->response->redirect('index/astronomy?city=' . $city . '&&type=' . $type);
    }
  }
  public function showAction()
  {
    // redirected to view
  }
  public function currentAction()
  {
    $city = $_GET['city'];
    $type = $_GET['type'];
    $data = $this->getInfo($city, $type);
    $output = "";
    $output .= "<section class=\"vh-100 bg-image\"
        style=\"background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');\">
        <div class=\"mask d-flex align-items-center h-100 gradient-custom-3\">
          <div class=\"container h-100\">
            <div class=\"row d-flex justify-content-center align-items-center h-100\">
              <div class=\"col-12 col-md-9 col-lg-7 col-xl-6\">
                <div class=\"card\" style=\"border-radius: 15px;\">
                  <div class=\"card-body p-5\">
                    <h2 class=\"text-uppercase text-center mb-5\">Weather App</h2>
                      <div class=\"form-outline mb-4\">
                        <h3 class = 'text-center'>";
    $output .= $data['location']['name'];
    $output .= "</h3><h5>";
    $output .= $data['location']['region'] . '  (' . $data['location']['country'];

    $output .= ")</h5><h6>Date/Time: ";
    $output .= $data['location']['localtime'];
    $output .= "</h6><h3>";
    $output .= $data['current']['temp_c'] . ' °C / ' . $data['current']['temp_f'] . ' °F';
    $output .= "<img src=" . $data['current']['condition']['icon'] . " class=\"rounded float-right\" alt=\"...\">";
    $output .= "</h3>";
    $output .= $data['current']['condition']['text'];
    $output .= "<br>Humidity : " . $data['current']['humidity'];
    $output .= "<br><h3 class = 'text-center'>Air Quality</h3>";
    $output .= "CO        : " . $data['current']['air_quality']['co'];
    $output .= "<br>NO2   : " . $data['current']['air_quality']['no2'];
    $output .= "<br>O3    : " . $data['current']['air_quality']['o3'];
    $output .= "<br>so2   : " . $data['current']['air_quality']['so2'];
    $output .= "<br>pm10  : " . $data['current']['air_quality']['pm10'];

    $output .= "</div>
         
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>";

    $this->view->data = $output;
    $this->dispatcher->forward(['action' => 'show', 'data' => $output]);
  }

  public function forecastAction()
  {
    $city = $_GET['city'];
    $type = $_GET['type'];
    $data = $this->getInfo($city, $type);
    $output = "";
    $output .= "<section class=\"vh-100 bg-image\"
        style=\"background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');\">
        <div class=\"mask d-flex align-items-center h-100 gradient-custom-3\">
          <div class=\"container h-100\">
            <div class=\"row d-flex justify-content-center align-items-center h-100\">
              <div class=\"col-12 col-md-9 col-lg-7 col-xl-6\">
                <div class=\"card\" style=\"border-radius: 15px;\">
                  <div class=\"card-body p-5\">
                    <h2 class=\"text-uppercase text-center mb-5\">Weather</h2>
                      <div class=\"form-outline mb-4\">
                        <h3>";
    $output .= $data['location']['name'];
    $output .= "</h3><h5>";
    $output .= $data['location']['region'] . '  (' . $data['location']['country'];

    $output .= ")</h5><h6>";
    $output .= $data['location']['localtime'];
    $output .= "</h6>";
    foreach ($data['forecast']['forecastday'] as $value) {
      $output .= "<hr><p>$value[date]</p>";
      $output .= "<img src=" . $value['day']['condition']['icon'] . " class=\"rounded float-right\" alt=\"...\">";
      $output .= "<div class=\"flex-column\">
            <p class=\"small\"><strong>Max Temp : ";
      $output .= $value['day']['maxtemp_c'];
      $output .= "°C</strong></p>";
      $output .= "<div class=\"flex-column\">
            <p class=\"small\"><strong> Min Temp : ";
      $output .= $value['day']['mintemp_c'];
      $output .= "°C</strong></p></div>";
    }
    $output .= "</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>";
    $this->view->data = $output;
    $this->dispatcher->forward(['action' => 'show', 'data' => $output]);
  }

  public function timezoneAction()
  {
    $city = $_GET['city'];
    $type = $_GET['type'];
    $data = $this->getInfo($city, $type);
    $output = "";
    $output .= "<section class=\"vh-100 bg-image\"
        style=\"background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');\">
        <div class=\"mask d-flex align-items-center h-100 gradient-custom-3\">
          <div class=\"container h-100\">
            <div class=\"row d-flex justify-content-center align-items-center h-100\">
              <div class=\"col-12 col-md-9 col-lg-7 col-xl-6\">
                <div class=\"card\" style=\"border-radius: 15px;\">
                  <div class=\"card-body p-5\">
                    <h2 class=\"text-uppercase text-center mb-5\">Time Zone</h2>
                      <div class=\"form-outline mb-4\">
                        <h3>";
    $output .= $data['location']['name'];
    $output .= "</h3><h5>";
    $output .= $data['location']['region'] . '  (' . $data['location']['country'];

    $output .= ")</h5><h6>";
    $output .= $data['location']['localtime'];
    $output .= "</h6><h6>";
    $output .= "Time Zone : " . $data['location']['tz_id'];
    $output .= "</h6>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>";
    $this->view->data = $output;
    $this->dispatcher->forward(['action' => 'show', 'data' => $output]);
  }

  public function sportsAction()
  {
    $city = $_GET['city'];
    $type = $_GET['type'];
    $data = $this->getInfo($city, $type);
    $output = "";
    $output .= "<section class=\"vh-100 bg-image\"
        style=\"background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');\">
        <div class=\"mask d-flex align-items-center h-100 gradient-custom-3\">
          <div class=\"container h-100\">
            <div class=\"row d-flex justify-content-center align-items-center h-100\">
              <div class=\"col-12 col-md-9 col-lg-7 col-xl-6\">
                <div class=\"card\" style=\"border-radius: 15px;\">
                  <div class=\"card-body p-5\">
                    <h2 class=\"text-uppercase text-center mb-5\">Sports</h2>
                      <div class=\"form-outline mb-4\">";
    foreach ($data as $key => $value) {
      $output .= "<hr></h4><h3>$key</h3>";
      foreach ($value as $ev) {
        $output .= "<p>$ev</p>";
      }
      $output .= "<br>";
    }
    $output .= "</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>";
    $this->view->data = $output;
    $this->dispatcher->forward(['action' => 'show', 'data' => $output]);
  }
  public function astronomyAction()
  {
    $city = $_GET['city'];
    $type = $_GET['type'];
    $data = $this->getInfo($city, $type);
    $output = "";
    $output .= "<section class=\"vh-100 bg-image\"
        style=\"background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');\">
        <div class=\"mask d-flex align-items-center h-100 gradient-custom-3\">
          <div class=\"container h-100\">
            <div class=\"row d-flex justify-content-center align-items-center h-100\">
              <div class=\"col-12 col-md-9 col-lg-7 col-xl-6\">
                <div class=\"card\" style=\"border-radius: 15px;\">
                  <div class=\"card-body p-5\">
                    <h2 class=\"text-uppercase text-center mb-5\">Astronomy</h2>
                      <div class=\"form-outline mb-4\">
                        <h3 class = 'text-center'>";
    $output .= $data['location']['name'];
    $output .= "</h3><h5>";
    $output .= $data['location']['region'] . '  (' . $data['location']['country'];

    $output .= ")</h5><h6>";
    $output .= $data['location']['localtime'];
    $output .= "</h6>";
    $output .= "<h3 class = 'text-center'>Astronomy</h3>";
    $output .= "<p>Sunrise :" . $data['astronomy']['astro']['sunrise'] . "</p>";
    $output .= "<p>Sunset :" . $data['astronomy']['astro']['sunset'] . "</p>";
    $output .= "<p>Moonrise :" . $data['astronomy']['astro']['moonrise'] . "</p>";
    $output .= "<p>Moonset :" . $data['astronomy']['astro']['moonset'] . "</p>";
    $output .= "<p>Moon phase :" . $data['astronomy']['astro']['moon_phase'] . "</p>";

    $output .= "</div>
         
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>";
    $this->view->data = $output;
    $this->dispatcher->forward(['action' => 'show', 'data' => $output]);
  }
  public function getInfo($city, $type)
  {

    $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => 'https://api.weatherapi.com/v1',
      // You can set any number of default request options.
      'timeout' => 10.0,
    ]);

    $endpoint = "/v1$type?key=0bab7dd1bacc418689b143833220304&&q=$city&&alerts=yes&&aqi=yes&&days=3";
    if ($type == '/history.json') {
      $date = '2023-05-07';
      $endpoint .= "&&dt=$date&&end_dt=2023-05-09";
    }
    $response = $client->request('GET', $endpoint);
    return (json_decode($response->getBody(), true));
  }
}
