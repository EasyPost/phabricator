<?php

final class PhabricatorSearchOpensearchController
  extends PhabricatorSearchBaseController {

  const SCOPE_CURRENT_APPLICATION = 'application';

  public function handleRequest(AphrontRequest $request) {
    $root = dirname(phutil_get_library_root('phabricator'));
    $logo = PhabricatorEnv::getEnvConfig('ui.logo');
    $title = idx($logo, 'wordmarkText', 'phabricator');

    $content = Filesystem::readFile(
      $root.'/resources/builtin/opensearch.xml');

    $content = preg_replace('/BASE_URI/', PhabricatorEnv::getURI('/search/'));
    $content = preg_replace('/TITLE/', $title);

    return id(new AphrontFileResponse())
      ->setContent($content)
      ->setMimeType("application/opensearchdescription+xml");
  }
}

?>
