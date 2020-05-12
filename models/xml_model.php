<?php
/* Mit Hilfe dieser Klasse werden Informationen aus der XML-datei geladen,
   die den Bildspeicher verwaltet.
*/
class XML_Model extends Model {
	
  var $xml = array();
  var $customer = array();
  var $st = array();
  
  function __construct() {
    $this->xml = simplexml_load_file(_XML_FILE_);
    foreach ($this->xml->customer as $c=>$cv) {
      $cdata=array();
      $cdata['name'] = $cv->name->__toString();
      $cdata['path'] = $cv->ftpdir->__toString();
      foreach($cv->project as $p=>$pv) {
        $pdata = array();
      	$pdata['name'] = $pv->name->__toString();
      	$pdata['path'] = $pv->path->__toString();
      	foreach($pv->camera as $k=>$kv) {
      	  $kdata = array();
      	  $kdata['name'] = $kv->name->__toString();
      	  $kdata['path'] = $kv->mac->__toString();
      	  $kdata['shorttag'] = $kv->shorttag->__toString();
      	  $kdata['active'] = $kv->active->__toString();
      	  $kdata['api'] = $kv->httpapi_type->__toString();
      	  $kdata['secret'] = $kv->secret->__toString();
      	  $kdata['url'] = $kv->ip->__toString().':'.$kv->port->__toString();
      	  $kdata['ip'] = $kv->ip->__toString();
      	  $kdata['routerport'] = $kv->router_port->__toString();
      	  foreach($kv->serie as $s=>$sv) {
      	    $sdata = array();
      	    $sdata['path'] = $sv->path->__toString();
      	    $kdata['serie'][] = $sdata;
      	    unset($sdata);
      	  }
      	  $pdata['webcam'][] = $kdata;
      	  $this->st[$kdata['shorttag']] = array('name' => $kdata['name'],
      	                                        'projekt' => $pdata['name'],
      	                                        'active' => $kdata['active']==1,
      	                                        'url' => $kdata['url'],
      	                                        'ip' => $kdata['ip'],
      	                                        'routerport' => $kdata['routerport'],
      	                                        'secret' => $kdata['secret'],
      	                                        'api' => $kdata['api']
      	                                  );
      	  unset($kdata);
        }
      	$cdata['project'][] = $pdata;
        unset($pdata);
      }
      $customer[]=$cdata;
      unset($cdata);
    } 
  }
  
  function api_image_path($api,$size="800x600") {
  	$url = '';
  	switch ($api) {
  	  case 'axis':
  	  	$url = '/axis-cgi/jpg/image.cgi?'.($size!=''?'resolution='.$size:'');
  	  	break;
  	  case 'm26m':
  	  case 'm12d':
  	  case 'm15d':
  	  default:
  	    $url = '/cgi-bin/image.jpg?'.($size!=''?'size='.$size:'').'&textdisplay=disable';
  	  	break;
  	  
  	}
  	return $url;
  }
  
}
?>