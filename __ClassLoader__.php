<?php declare(strict_types=1);
namespace Tiny;
        
class __ClassLoader__ {
  public static $classMap = array (
  'Tiny\\Integrator' => '/Integrator.php',
  'API\\Test' => '/src/api/Test.php',
  'API\\TestLogin' => '/src/api/TestLogin.php',
  'TinyDB\\AccountUser' => '/src/db/AccountUser.php',
  'TinyDB\\AccountUserInfo' => '/src/db/AccountUserInfo.php',
  'TinyDB\\Config' => '/src/db/Config.php',
  'TinyDB\\DB' => '/src/db/DB.php',
  'Enum\\ResultEnum' => '/src/enum/ResultEnum.php',
  'API\\Item' => '/src/parameter/Item.php',
  'API\\TestLoginRequest' => '/src/parameter/TestLoginRequest.php',
  'API\\TestLoginResponse' => '/src/parameter/TestLoginResponse.php',
  'API\\TestRequest' => '/src/parameter/TestRequest.php',
  'API\\TestResponse' => '/src/parameter/TestResponse.php',
  'Helper\\TestTask' => '/src/task/TestTask.php',
  'Tiny\\API' => '/tiny/API/API.php',
  'Tiny\\API\\HttpStatus' => '/tiny/API/HttpStatus.php',
  'Tiny\\Main' => '/tiny/API/Main.php',
  'Tiny\\API\\Request' => '/tiny/API/Request.php',
  'Tiny\\API\\Response' => '/tiny/API/Response.php',
  'Tiny\\Algorithm\\Linear\\LinkedList' => '/tiny/Algorithm/Linear/LinkedList.php',
  'Tiny\\Algorithm\\Linear\\Node' => '/tiny/Algorithm/Linear/Node.php',
  'Tiny\\Algorithm\\Linear\\Queue' => '/tiny/Algorithm/Linear/Queue.php',
  'Tiny\\Algorithm\\Linear\\Stack' => '/tiny/Algorithm/Linear/Stack.php',
  'Tiny\\Annotation\\File' => '/tiny/Annotation/File.php',
  'Tiny\\Annotation\\Property' => '/tiny/Annotation/Property.php',
  'Tiny\\Annotation\\Type\\ArrayType' => '/tiny/Annotation/Type/ArrayType.php',
  'Tiny\\Annotation\\Type\\PrimitiveType' => '/tiny/Annotation/Type/PrimitiveType.php',
  'Tiny\\Annotation\\Type' => '/tiny/Annotation/Type/Type.php',
  'Tiny\\Annotation\\Type\\UserDefinedType' => '/tiny/Annotation/Type/UserDefinedType.php',
  'Tiny\\Annotation\\Uses\\Optional' => '/tiny/Annotation/Uses/Optional.php',
  'Tiny\\Annotation\\Uses\\Required' => '/tiny/Annotation/Uses/Required.php',
  'Tiny\\Annotation\\Uses' => '/tiny/Annotation/Uses/Uses.php',
  'Tiny\\Cache' => '/tiny/Cache/Cache.php',
  'Tiny\\Cache\\CacheDB' => '/tiny/Cache/CacheDB.php',
  'Tiny\\Cache\\Config' => '/tiny/Cache/Config.php',
  'Tiny\\OperationConfig' => '/tiny/Config/OperationConfig.php',
  'Tiny\\Converter' => '/tiny/Converter/Converter.php',
  'Tiny\\Enum\\Enum' => '/tiny/Enum/Enum.php',
  'Tiny\\Exception\\AlgorithmException' => '/tiny/Exception/AlgorithmException.php',
  'Tiny\\Exception\\ConverterException' => '/tiny/Exception/ConverterException.php',
  'Tiny\\Foundation\\Client\\CurlGetHttp' => '/tiny/Foundation/Client/CurlGetHttp.php',
  'Tiny\\Foundation\\Client\\CurlHttp' => '/tiny/Foundation/Client/CurlHttp.php',
  'Tiny\\Foundation\\Client\\CurlPostHttp' => '/tiny/Foundation/Client/CurlPostHttp.php',
  'Tiny\\Foundation\\Client\\HttpBuilder' => '/tiny/Foundation/Client/HttpBuilder.php',
  'Tiny\\Foundation\\Server\\API' => '/tiny/Foundation/Server/API/API.php',
  'Tiny\\Foundation\\Server\\JsonAPI' => '/tiny/Foundation/Server/API/JsonAPI.php',
  'Tiny\\Foundation\\Server\\Login\\LoginAPI' => '/tiny/Foundation/Server/API/Login/LoginAPI.php',
  'Tiny\\Foundation\\Server\\Login\\MultiClientLoginAPI' => '/tiny/Foundation/Server/API/Login/MultiClientLoginAPI.php',
  'Tiny\\Foundation\\Server\\Login\\SingleClientLoginAPI' => '/tiny/Foundation/Server/API/Login/SingleClientLoginAPI.php',
  'Tiny\\Foundation\\Server\\Logout\\LogoutAPI' => '/tiny/Foundation/Server/API/Logout/LogoutAPI.php',
  'Tiny\\Foundation\\Server\\XmlAPI' => '/tiny/Foundation/Server/API/XmlAPI.php',
  'Tiny\\Foundation\\Server\\Code' => '/tiny/Foundation/Server/Code.php',
  'Tiny\\Foundation\\Server\\Login\\LoginAPIRequest' => '/tiny/Foundation/Server/Parameter/Login/LoginAPIRequest.php',
  'Tiny\\Foundation\\Server\\Login\\LoginAPIResponse' => '/tiny/Foundation/Server/Parameter/Login/LoginAPIResponse.php',
  'Tiny\\Foundation\\Server\\Logout\\LogoutAPIRequest' => '/tiny/Foundation/Server/Parameter/Logout/LogoutAPIRequest.php',
  'Tiny\\Foundation\\Server\\Logout\\LogoutAPIResponse' => '/tiny/Foundation/Server/Parameter/Logout/LogoutAPIResponse.php',
  'Tiny\\Foundation\\Server\\Request' => '/tiny/Foundation/Server/Parameter/Request.php',
  'Tiny\\Foundation\\Server\\Response' => '/tiny/Foundation/Server/Parameter/Response.php',
  'Tiny\\Helper\\Time' => '/tiny/Helper/Time.php',
  'Tiny\\Http\\Client\\CurlGetHttp' => '/tiny/Http/Client/CurlGetHttp.php',
  'Tiny\\Http\\Client\\CurlHttp' => '/tiny/Http/Client/CurlHttp.php',
  'Tiny\\Http\\Client\\CurlPostHttp' => '/tiny/Http/Client/CurlPostHttp.php',
  'Tiny\\Http\\Client\\HttpBuilder' => '/tiny/Http/Client/HttpBuilder.php',
  'Tiny\\Http\\API' => '/tiny/Http/Server/API/API.php',
  'Tiny\\Http\\JsonAPI' => '/tiny/Http/Server/API/JsonAPI.php',
  'Tiny\\Http\\Login\\LoginAPI' => '/tiny/Http/Server/API/Login/LoginAPI.php',
  'Tiny\\Http\\Login\\MultiClientLoginAPI' => '/tiny/Http/Server/API/Login/MultiClientLoginAPI.php',
  'Tiny\\Http\\Login\\SingleClientLoginAPI' => '/tiny/Http/Server/API/Login/SingleClientLoginAPI.php',
  'Tiny\\Http\\Logout\\LogoutAPI' => '/tiny/Http/Server/API/Logout/LogoutAPI.php',
  'Tiny\\Http\\XmlAPI' => '/tiny/Http/Server/API/XmlAPI.php',
  'Tiny\\Http\\Code' => '/tiny/Http/Server/Code.php',
  'Tiny\\Http\\Login\\LoginAPIRequest' => '/tiny/Http/Server/Parameter/Login/LoginAPIRequest.php',
  'Tiny\\Http\\Login\\LoginAPIResponse' => '/tiny/Http/Server/Parameter/Login/LoginAPIResponse.php',
  'Tiny\\Http\\Logout\\LogoutAPIRequest' => '/tiny/Http/Server/Parameter/Logout/LogoutAPIRequest.php',
  'Tiny\\Http\\Logout\\LogoutAPIResponse' => '/tiny/Http/Server/Parameter/Logout/LogoutAPIResponse.php',
  'Tiny\\Http\\Request' => '/tiny/Http/Server/Parameter/Request.php',
  'Tiny\\Http\\Response' => '/tiny/Http/Server/Parameter/Response.php',
  'Tiny\\Loader' => '/tiny/Loader/Loader.php',
  'Tiny\\Logger' => '/tiny/Logger/Logger.php',
  'Tiny\\MongoDB\\Config' => '/tiny/MongoDB/Config.php',
  'Tiny\\MongoDB\\Filter' => '/tiny/MongoDB/Filter.php',
  'Tiny\\MongoDB\\Info' => '/tiny/MongoDB/Info.php',
  'Tiny\\MongoDB\\Model' => '/tiny/MongoDB/Model.php',
  'Tiny\\MongoDB\\MongoDB' => '/tiny/MongoDB/MongoDB.php',
  'Tiny\\MongoDB\\NewObject' => '/tiny/MongoDB/NewObject.php',
  'Tiny\\MongoDB\\Op\\EqStrategy' => '/tiny/MongoDB/Op/EqStrategy.php',
  'Tiny\\MongoDB\\Op\\GtStrategy' => '/tiny/MongoDB/Op/GtStrategy.php',
  'Tiny\\MongoDB\\Op\\GteStrategy' => '/tiny/MongoDB/Op/GteStrategy.php',
  'Tiny\\MongoDB\\Op\\LtStrategy' => '/tiny/MongoDB/Op/LtStrategy.php',
  'Tiny\\MongoDB\\Op\\LteStrategy' => '/tiny/MongoDB/Op/LteStrategy.php',
  'Tiny\\MongoDB\\Op\\NeStrategy' => '/tiny/MongoDB/Op/NeStrategy.php',
  'Tiny\\MongoDB\\Op\\OpStrategy' => '/tiny/MongoDB/Op/OpStrategy.php',
  'Tiny\\MongoDB\\OpEnum' => '/tiny/MongoDB/OpEnum.php',
  'Tiny\\MongoDB\\QueryOptions' => '/tiny/MongoDB/QueryOptions.php',
  'Tiny\\MongoDB\\SortEnum' => '/tiny/MongoDB/SortEnum.php',
  'Tiny\\MySQL\\Config' => '/tiny/MySQL/Config.php',
  'Tiny\\MySQL\\Model' => '/tiny/MySQL/Model.php',
  'Tiny\\MySQL\\MySQL' => '/tiny/MySQL/MySQL.php',
  'Tiny\\Net\\Config' => '/tiny/Net/Config.php',
  'Tiny\\Net' => '/tiny/Net/Net.php',
  'Tiny\\Net\\NetDB' => '/tiny/Net/NetDB.php',
  'Tiny\\NetValue' => '/tiny/Net/NetValue.php',
  'Tiny\\Pool\\Redis\\RedisPool' => '/tiny/Pool/Redis/RedisPool.php',
  'Tiny\\Redis\\Config' => '/tiny/Redis/Config.php',
  'Tiny\\Redis' => '/tiny/Redis/Redis.php',
  'Tiny\\Serialize\\JsonSerializeStrategy' => '/tiny/Serialize/JsonSerializeStrategy.php',
  'Tiny\\Serialize\\SerializeStrategy' => '/tiny/Serialize/SerializeStrategy.php',
  'Tiny\\Serialize\\XmlSerializeStrategy' => '/tiny/Serialize/XmlSerializeStrategy.php',
  'Tiny\\Task' => '/tiny/Task/Task.php',
  'Tiny\\TaskCenter' => '/tiny/Task/TaskCenter.php',
);
}