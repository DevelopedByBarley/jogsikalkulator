<?php

namespace Core;

class Session
{

  public static function create()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    // Rotate flash data: available for one subsequent request.
    if (isset($_SESSION['_flash'])) {
      unset($_SESSION['_flash']);
    }
    if (isset($_SESSION['_flash_new'])) {
      $_SESSION['_flash'] = $_SESSION['_flash_new'];
      unset($_SESSION['_flash_new']);
    }
  }


  public static function has($key)
  {
    return (bool)static::get($key);
  }

  public static function put($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public static function get($key, $default = null)
  {
    return $_SESSION[$key] ?? $_SESSION['_flash'][$key] ?? $default;
  }

  public static function unset($key)
  {
    if (isset($_SESSION[$key])) unset($_SESSION[$key]);
  }

  public static function flash($key, $value)
  {
    $_SESSION['_flash_new'][$key] = $value;
  }

  public static function unflash()
  {
    if (isset($_SESSION['_flash'])) unset($_SESSION['_flash']);
  }

  public static function flush()
  {
    $_SESSION = [];
  }

  /**
   * A session írásának lezárása és a fájlzár azonnali feloldása.
   *
   * A session_start() kizárólagos zárat tart a session fájlon a kérés
   * végéig, ezért ugyanattól a felhasználótól érkező PÁRHUZAMOS kérések
   * (pl. az élő kereső egymást követő AJAX hívásai) egymásra várnak, és
   * 30 mp után timeoutolnak. A csak-olvasó végpontok ezzel a kérés elején
   * elengedik a zárat – a $_SESSION tömb utána is olvasható marad, csak
   * új írás nem íródik vissza.
   */
  public static function close(): void
  {
    if (session_status() === PHP_SESSION_ACTIVE) {
      session_write_close();
    }
  }
}
