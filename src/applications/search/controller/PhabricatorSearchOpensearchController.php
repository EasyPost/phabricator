<?php

final class PhabricatorSearchOpensearchController
  extends PhabricatorSearchBaseController {

  const SCOPE_CURRENT_APPLICATION = 'application';

  public function shouldRequireLogin() {
    return false;
  }

  public function shouldAllowPartialSessions() {
    return true;
  }

  public function handleRequest(AphrontRequest $request) {
    $root = dirname(phutil_get_library_root('phabricator'));
    $logo = PhabricatorEnv::getEnvConfig('ui.logo');
    $title = idx($logo, 'wordmarkText', 'phabricator');

    $content = Filesystem::readFile(
      $root.'/resources/builtin/opensearch.xml');

    $content = preg_replace('/OPENSEARCH_URI/', PhabricatorEnv::getURI('/opensearch.xml'), $content);
    $content = preg_replace('/BASE_URI/', PhabricatorEnv::getURI('/search/'), $content);
    $content = preg_replace('/FAVICON_URI/', PhabricatorEnv::getURI('favicon.ico'), $content);
    $content = preg_replace('/TITLE/', $title, $content);

    return id(new AphrontFileResponse())
      ->setContent($content)
      ->setMimeType("application/opensearchdescription+xml")
      ->setCanCDN(true)
      ->setCacheDurationInSeconds(60 * 60 * 24 * 7);
  }
}

?>
