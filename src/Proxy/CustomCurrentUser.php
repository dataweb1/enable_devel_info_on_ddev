<?php
namespace Drupal\enable_devel_info_on_ddev\Proxy;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Session\AccountInterface;

class CustomCurrentUser implements AccountProxyInterface {
  /**
   * The original account proxy service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $innerAccountProxy;

  public function __construct(AccountProxyInterface $innerAccountProxy) {
    $this->innerAccountProxy = $innerAccountProxy;
  }

  /**
   * Overrides or extends the permission check.
   */
  public function hasPermission($permission) {
    // Check the specific condition (e.g., being in a DDEV environment).
    if ($permission === 'access devel information' && getenv('IS_DDEV_PROJECT') === 'true') {
      return TRUE;
    }

    // Otherwise, defer to the original account proxy service.
    return $this->innerAccountProxy->hasPermission($permission);
  }

  // Delegate all other AccountProxyInterface methods to the inner service.
  public function getAccount() {
    return $this->innerAccountProxy->getAccount();
  }

  public function setAccount(AccountInterface $account) {
    $this->innerAccountProxy->setAccount($account);
  }

  // Implement all other methods required by AccountProxyInterface...
  public function id() {
    return $this->innerAccountProxy->id();
  }

  public function getRoles($exclude_locked_roles = FALSE) {
    return $this->innerAccountProxy->getRoles();
  }

  public function isAuthenticated() {
    return $this->innerAccountProxy->isAuthenticated();
  }

  public function isAnonymous() {
    return $this->innerAccountProxy->isAnonymous();
  }

  public function getPreferredLangcode($fallback_to_default = TRUE) {
    return $this->innerAccountProxy->getPreferredLangcode();
  }

  public function getPreferredAdminLangcode($fallback_to_default = TRUE) {
    return $this->innerAccountProxy->getPreferredAdminLangcode();
  }

  public function getAccountName() {
    return $this->innerAccountProxy->getAccountName();
  }

  public function getDisplayName() {
    return $this->innerAccountProxy->getDisplayName();
  }

  public function getEmail() {
    return $this->innerAccountProxy->getEmail();
  }

  public function getTimeZone() {
    return $this->innerAccountProxy->getTimeZone();
  }

  public function getLastAccessedTime() {
    return $this->innerAccountProxy->getLastAccessedTime();
  }

  public function setInitialAccountId($account_id) {
    return $this->innerAccountProxy->setInitialAccountId($account_id);
  }

}
