<?php

set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

require_once("lib/BaseBatch.php");
require_once("lib/TheWorld.php");
require_once("lib/DB/DataLoader.php");
require_once("lib/util/Util.php");
require_once("lib/util/KFile.php");
require_once("lib/KException.php");

class DataLoaderBatch extends BaseBatch {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function xmain($args) {
    $fileName = $args[1];

    $file = KFile::new()->setPath($fileName);
    if (!$file->isExist()) {
      throw new KException("DataLoader::xmain(): file does not exist: " . $fileName);
    }
    
    $loader = new DataLoader(); 
    
    $loader->load($fileName);

    return $this;
  }

}

if (count($argv) != 2) {
  Util::println("usage: php DataLoaderBatch.php data.dat");
  exit(-1);
}

$obj = new DataLoaderBatch();
try {
  $obj->run($argv);
}
catch(Exception $e) {
  printf("DataLoaderBatch: error: " . $e->getMessage());
}

return 1;

?>