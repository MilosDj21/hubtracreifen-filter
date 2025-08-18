<?php

/**
 * Plugin Name: Product Filter
 * Description: Custom filter for products
 * Author:      MilosDj21
 * Version:     1.0.0
 */

defined('ABSPATH') or die("Cannot access pages directly.");

class ProductFilter
{
  private $vehicle = null;
  private $position = null;
  private $breite = null;
  private $profil = null;
  private $felge = null;
  private $produkttyp = null;
  private $reifentyp = null;

  public function __construct()
  {
    add_shortcode('renderProductFilter', array($this, 'parseShortcode'));
    add_action('init', array($this, 'handleForm'));
    add_action('pre_get_posts', array($this, 'modifyQuery'));
  }

  public function parseShortcode()
  {
    $selectedVehicle = null;
    if (isset($_GET["selectedVehicle"])) {
      $selectedVehicle = $_GET["selectedVehicle"];
    }

    $selectedBreite = null;
    if (isset($_GET["selectedBreite"])) {
      $selectedBreite = $_GET["selectedBreite"];
    }

    $selectedProfil = null;
    if (isset($_GET["selectedProfil"])) {
      $selectedProfil = $_GET["selectedProfil"];
    }

    $selectedFelge = null;
    if (isset($_GET["selectedFelge"])) {
      $selectedFelge = $_GET["selectedFelge"];
    }

    $selectedProdukttyp = null;
    if (isset($_GET["selectedProdukttyp"])) {
      $selectedProdukttyp = $_GET["selectedProdukttyp"];
    }

    $selectedReifentyp = null;
    if (isset($_GET["selectedReifentyp"])) {
      $selectedReifentyp = $_GET["selectedReifentyp"];
    }

    ob_start();?>
          <form method="GET">
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Fahrzeugtyp</h2>
            <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/main-truck.png" alt="all axle truck" style="height:40px; width:auto; margin-bottom:0.5rem;">
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:2rem;">
                <!-- truck all -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="all" <?php echo $selectedVehicle === "all" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">All Axles</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/all-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- truck steer -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="steer" <?php echo $selectedVehicle === "steer" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Steering Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/steer-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- truck drive -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="drive" <?php echo $selectedVehicle === "drive" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Drive Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/drive-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- truck trail -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="trail" <?php echo $selectedVehicle === "trail" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Trailer</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/trail-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>
            </div>

            <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/main-loader.png" alt="all axle truck" style="height:40px; width:auto; margin-bottom:0.5rem;">
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:2rem;">
                <!-- loader all -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="loader-all" <?php echo $selectedVehicle === "loader-all" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">All Axles</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/all-cargo-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- loader steer -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="loader-steer" <?php echo $selectedVehicle === "loader-steer" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Steering Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/steer-cargo-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- loader drive -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="loader-drive" <?php echo $selectedVehicle === "loader-drive" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Drive Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/drive-cargo-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>
            </div>

            <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/main-bus.png" alt="all axle truck" style="height:40px; width:auto; margin-bottom:0.5rem;">
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:2rem;">
                <!-- bus all -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="bus-all" <?php echo $selectedVehicle === "bus-all" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">All Axles</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/all-bus-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- bus steer -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="bus-steer" <?php echo $selectedVehicle === "bus-steer" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Steering Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/steer-bus-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>

                <!-- bus drive -->
                <label style="cursor:pointer; margin-right:15px; display:inline-flex; align-items:center; justify-content:space-between;" >
                    <input style="display:none;" type="radio" name="selectedVehicle" value="bus-drive" <?php echo $selectedVehicle === "bus-drive" ? "checked" : "" ?> onchange="this.form.submit()"/>
                    <span style="color:black;">Drive Axle</span>
                    <img src="https://hubtracreifen.test/wp-content/uploads/2025/08/drive-bus-scaled.png" alt="all axle truck" style="height:25px; width:auto;">
                </label>
            </div>

            <!--Breite-->
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Breite</h2>
            <select style="margin-bottom:2rem;" name="selectedBreite" onchange="this.form.submit()">
                <option value="all" <?php echo $selectedBreite == "all" ? "selected" : ""; ?>>Alle</option>
                <option value="205" <?php echo $selectedBreite == "205" ? "selected" : ""; ?>>205</option>
                <option value="215" <?php echo $selectedBreite == "215" ? "selected" : ""; ?>>215</option>
                <option value="225" <?php echo $selectedBreite == "225" ? "selected" : ""; ?>>225</option>
                <option value="235" <?php echo $selectedBreite == "235" ? "selected" : ""; ?>>235</option>
                <option value="245" <?php echo $selectedBreite == "245" ? "selected" : ""; ?>>245</option>
                <option value="265" <?php echo $selectedBreite == "265" ? "selected" : ""; ?>>265</option>
                <option value="275" <?php echo $selectedBreite == "275" ? "selected" : ""; ?>>275</option>
                <option value="285" <?php echo $selectedBreite == "285" ? "selected" : ""; ?>>285</option>
                <option value="295" <?php echo $selectedBreite == "295" ? "selected" : ""; ?>>295</option>
                <option value="305" <?php echo $selectedBreite == "305" ? "selected" : ""; ?>>305</option>
                <option value="315" <?php echo $selectedBreite == "315" ? "selected" : ""; ?>>315</option>
                <option value="385" <?php echo $selectedBreite == "385" ? "selected" : ""; ?>>385</option>
                <option value="425" <?php echo $selectedBreite == "425" ? "selected" : ""; ?>>425</option>
                <option value="435" <?php echo $selectedBreite == "435" ? "selected" : ""; ?>>435</option>
                <option value="445" <?php echo $selectedBreite == "445" ? "selected" : ""; ?>>445</option>
            </select>

            <!--Profil-->
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Profile</h2>
            <select style="margin-bottom:2rem;" name="selectedProfil" onchange="this.form.submit()">
                <option value="all" <?php echo $selectedProfil === "all" ? "selected" : ""; ?>>Alle</option>
                <option value="13" <?php echo $selectedProfil === "13" ? "selected" : ""; ?>>13</option>
                <option value="45" <?php echo $selectedProfil === "45" ? "selected" : ""; ?>>45</option>
                <option value="50" <?php echo $selectedProfil === "50" ? "selected" : ""; ?>>50</option>
                <option value="55" <?php echo $selectedProfil === "55" ? "selected" : ""; ?>>55</option>
                <option value="60" <?php echo $selectedProfil === "60" ? "selected" : ""; ?>>60</option>
                <option value="65" <?php echo $selectedProfil === "65" ? "selected" : ""; ?>>65</option>
                <option value="70" <?php echo $selectedProfil === "70" ? "selected" : ""; ?>>70</option>
                <option value="75" <?php echo $selectedProfil === "75" ? "selected" : ""; ?>>75</option>
                <option value="80" <?php echo $selectedProfil === "80" ? "selected" : ""; ?>>80</option>
            </select>

            <!--Felge-->
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Felge</h2>
            <select style="margin-bottom:2rem;" name="selectedFelge" onchange="this.form.submit()">
                <option value="all" <?php echo $selectedFelge === "all" ? "selected" : ""; ?>>Alle</option>
                <option value="17.5" <?php echo $selectedFelge === "17.5" ? "selected" : ""; ?>>17.5</option>
                <option value="19.5" <?php echo $selectedFelge === "19.5" ? "selected" : ""; ?>>19.5</option>
                <option value="22.5" <?php echo $selectedFelge === "22.5" ? "selected" : ""; ?>>22.5</option>
            </select>

            <!--Produkttyp-->
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Produkttyp</h2>
            <select style="margin-bottom:2rem;" name="selectedProdukttyp" onchange="this.form.submit()">
                <option value="all" <?php echo $selectedProdukttyp === "all" ? "selected" : ""; ?>>Alle</option>
                <option value="classic" <?php echo $selectedProdukttyp === "classic" ? "selected" : ""; ?>>Klassisch</option>
                <option value="hubtrac2-0" <?php echo $selectedProdukttyp === "hubtrac2-0" ? "selected" : ""; ?>>Hubtrac 2.0</option>
            </select>

            <!--Reifentyp-->
            <h2 style="border-bottom:3px solid #e60013; font-size:1.375rem; font-weight:900; padding-bottom:1rem; text-transform:uppercase; width:100%; line-height:1.075rem; margin-bottom:1rem">Reifentyp</h2>
            <select style="margin-bottom:2rem;" name="selectedReifentyp" onchange="this.form.submit()">
                <option value="all" <?php echo $selectedReifentyp === "all" ? "selected" : ""; ?>>Alle</option>
                <option value="on-off-road" <?php echo $selectedReifentyp === "on-off-road" ? "selected" : ""; ?>>On/Off Road</option>
                <option value="regional" <?php echo $selectedReifentyp === "regional" ? "selected" : ""; ?>>Regional</option>
                <option value="winter" <?php echo $selectedReifentyp === "winter" ? "selected" : ""; ?>>Winter</option>
                <option value="highway" <?php echo $selectedReifentyp === "highway" ? "selected" : ""; ?>>Highway</option>
                <option value="long-haul" <?php echo $selectedReifentyp === "long-haul" ? "selected" : ""; ?>>Long Haul</option>
                <option value="urban" <?php echo $selectedReifentyp === "urban" ? "selected" : ""; ?>>Urban</option>
            </select>

            <input type="hidden" name="justsubmitted" value="true">
          </form>
        <?php
    return ob_get_clean();
  }

  public function handleForm()
  {
    //TODO: namesti da dinamicki povlaci iz baze sve termse za atribute
    // posto ce se dodavati novi u buducnosti

    if (isset($_GET['justsubmitted']) && $_GET['justsubmitted'] == "true") {
      if (isset($_GET['selectedVehicle'])) {
        switch ($_GET['selectedVehicle']) {
          case "all":
            $this->vehicle = 'truck';
            $this->position = 'all';
            break;
          case "steer":
            $this->vehicle = 'truck';
            $this->position = 'steer';
            break;
          case "drive":
            $this->vehicle = 'truck';
            $this->position = 'drive';
            break;
          case "trail":
            $this->vehicle = 'truck';
            $this->position = 'trail';
            break;
          case "loader-all":
            $this->vehicle = 'loader';
            $this->position = 'all';
            break;
          case "loader-steer":
            $this->vehicle = 'loader';
            $this->position = 'steer';
            break;
          case "loader-drive":
            $this->vehicle = 'loader';
            $this->position = 'drive';
            break;
          case "bus-all":
            $this->vehicle = 'bus';
            $this->position = 'all';
            break;
          case "bus-steer":
            $this->vehicle = 'bus';
            $this->position = 'steer';
            break;
          case "bus-drive":
            $this->vehicle = 'bus';
            $this->position = 'drive';
            break;
        }
      }
      if (isset($_GET['selectedBreite'])) {
        switch ($_GET['selectedBreite']) {
          case "all":
            $this->breite = 'all';
            break;
          case "205":
            $this->breite = '205';
            break;
          case "215":
            $this->breite = '215';
            break;
          case "225":
            $this->breite = '225';
            break;
          case "235":
            $this->breite = '235';
            break;
          case "245":
            $this->breite = '245';
            break;
          case "265":
            $this->breite = '265';
            break;
          case "275":
            $this->breite = '275';
            break;
          case "285":
            $this->breite = '285';
            break;
          case "295":
            $this->breite = '295';
            break;
          case "305":
            $this->breite = '305';
            break;
          case "315":
            $this->breite = '315';
            break;
          case "385":
            $this->breite = '385';
            break;
          case "425":
            $this->breite = '425';
            break;
          case "435":
            $this->breite = '435';
            break;
          case "445":
            $this->breite = '445';
            break;
        }
      }

      if (isset($_GET['selectedProfil'])) {
        switch ($_GET['selectedProfil']) {
          case "all":
            $this->profil = 'all';
            break;
          case "13":
            $this->profil = '13';
            break;
          case "45":
            $this->profil = '45';
            break;
          case "50":
            $this->profil = '50';
            break;
          case "55":
            $this->profil = '55';
            break;
          case "60":
            $this->profil = '60';
            break;
          case "65":
            $this->profil = '65';
            break;
          case "70":
            $this->profil = '70';
            break;
          case "75":
            $this->profil = '75';
            break;
          case "80":
            $this->profil = '80';
            break;
        }
      }

      if (isset($_GET['selectedFelge'])) {
        switch ($_GET['selectedFelge']) {
          case "all":
            $this->felge = 'all';
            break;
          case "17.5":
            $this->felge = '17.5';
            break;
          case "19.5":
            $this->felge = '19.5';
            break;
          case "22.5":
            $this->felge = '22.5';
            break;
        }
      }

      if (isset($_GET['selectedProdukttyp'])) {
        switch ($_GET['selectedProdukttyp']) {
          case "all":
            $this->produkttyp = 'all';
            break;
          case "classic":
            $this->produkttyp = 'classic';
            break;
          case "hubtrac2-0":
            $this->produkttyp = 'hubtrac2-0';
            break;
        }
      }

      if (isset($_GET['selectedReifentyp'])) {
        switch ($_GET['selectedReifentyp']) {
          case "all":
            $this->reifentyp = 'all';
            break;
          case "on-off-road":
            $this->reifentyp = 'on-off-road';
            break;
          case "regional":
            $this->reifentyp = 'regional';
            break;
          case "winter":
            $this->reifentyp = 'winter';
            break;
          case "highway":
            $this->reifentyp = 'highway';
            break;
          case "long-haul":
            $this->reifentyp = 'long-haul';
            break;
          case "urban":
            $this->reifentyp = 'urban';
            break;
        }
      }
    }
  }

  public function modifyQuery($query)
  {
    if (!is_admin() && $query->is_main_query()) {
      $tax_query = [];
      $filters = [
        "position" => $this->position,
        "breite" => $this->breite,
        "profil" => $this->profil,
        "felge" => $this->felge,
        "produkttyp" => $this->produkttyp,
        "reifentyp" => $this->reifentyp
      ];

      if ($this->vehicle) {
        $tax_query[] = array(
          'taxonomy' => 'pa_vehicle',
          'field' => 'slug',
          'terms' => array($this->vehicle),
          'operator' => 'IN'
        );
      }

      $tax_query['relation'] = 'AND';

      foreach ($filters as $key => $filter) {
        if ($filter && $filter != 'all') {
          $tax_query[] = array(
            'taxonomy' => "pa_$key",
            'field' => 'slug',
            'terms' => array($filter),
            'operator' => 'IN'
          );
        }
      }

      $query->set('tax_query', $tax_query);
      wp_reset_postdata();
    }
  }
}

$productFilter = new ProductFilter();
