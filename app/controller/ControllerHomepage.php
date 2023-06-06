<?php
require_once MODEL_DIR . 'ModelUser.php';
require_once MODEL_DIR . 'ModelSpeciality.php';

class ControllerHomepage
{
// --- page d'acceuil
    public static function viewHomepage($args)
    {
        include 'config.php';
        if (isset($_POST) && isset($_POST['user'])) {
            $user = new ModelUser(array_map('Model::processChars', $_POST['user']));
            $user = ModelUser::login($user);
            if ($user) {
                $_SESSION['user'] = $user = new ModelUser($user);
            } else {
                header(sprintf('Location: %sconnexion?code_err=2', BASE_URL));
            }
        }
        $vue = VIEW_DIR . 'homepage/viewHomepage.php';
        if (DEBUG) {
            echo("ControllerHomepage : viewHomepage : vue = $vue");
        }
        require($vue);
    }

    public static function login($args) {
        include 'config.php';
        $vue = VIEW_DIR . 'homepage/viewLogin.php';
        if (DEBUG) {
            echo("ControllerHomepage : login : vue = $vue");
        }
        require($vue);
    }

    public static function subscribe($args) {
        include 'config.php';
        if(isset($_SESSION['temp_user'])) {
            $temp_user = $_SESSION['temp_user'];
        }
        $results = ModelSpeciality::getAll()[2];
        $vue = VIEW_DIR . 'homepage/viewSubscribe.php';
        if (DEBUG) {
            echo("ControllerHomepage : subscribe : vue = $vue");
        }
        require($vue);
    }
    public static function subscribed($args) {
        include 'config.php';
        $newUser = array_map('Model::processChars', $_POST['user']);
        $results = ModelUser::insert($newUser);
        if ($results === -1) {
            $_SESSION['temp_user'] = $newUser;
            header(sprintf('Location: %sinscription?code_err=1', BASE_URL));
        } elseif($results === -2) {
            $_SESSION['temp_user'] = $newUser;
            header(sprintf('Location: %sinscription?code_err=2', BASE_URL));
        } else {
            unset($_SESSION['temp_user']);
            header(sprintf('Location: %sconnexion?code_suc=1&id=%s', BASE_URL, $results));
        }

    }

    public static function upgradeInnov() {
        include 'config.php';
        $vue = VIEW_DIR . 'homepage/viewUpgradeInnov.php';
        if (DEBUG) {
            echo("ControllerHomepage : upgradeInnov : vue = $vue");
        }
        require($vue);
    }

    public static function originalInnov() {
        include 'config.php';
        list($nbColumns, $columns, $result) = ModelUser::getMostFreeDoctor();
        $results['praticiens les plus libres'] = [$columns, $result];
        list($nbColumns, $columns, $result) = ModelUser::getMostAskedDoctor();
        $results['praticiens les plus populaires'] = [$columns, $result];
        list($nbColumns, $columns, $result) = ModelUser::getMostPopularDoctorAddress();
        $results['villes les plus populaires des praticiens'] = [$columns, $result];
        list($nbColumns, $columns, $result) = ModelUser::getMostPopularSpeciality();
        $results['spécialités les plus courantes'] = [$columns, $result];
        $results['plus demandé de Paris en généraliste'] = ModelUser::getMostAskedDoctorByAddressAndSpeciality('Paris', 1);

        $vue = VIEW_DIR . 'homepage/viewOriginalInnov.php';
        if (DEBUG) {
            echo("ControllerHomepage : originalInnov : vue = $vue");
        }
        require($vue);
    }


    public static function display404() {
        include 'config.php';
        $vue = VIEW_DIR . 'homepage/view404.php';
        if (DEBUG) {
            echo("ControllerHomepage : originalInnov : vue = $vue");
        }
        require($vue);
    }
}