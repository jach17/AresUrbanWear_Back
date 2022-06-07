<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

/* WE NEED TO REFACTOR FOLLOWING THE CORRECT PATTERN */

require '../src/Infrastructure/DB/db.php';


return function (App $app) {
    /*

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

*/
    $app->get('/api/cliente/{id}', function (Request $request, Response $response) {
        $idCliente = $request->getAttribute('id');
        $sql = "SELECT * FROM cliente WHERE idCliente = $idCliente";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $cliente = $resultado->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($cliente);
            } else {
                $cliente = "No hay cliente con ese ID";
                $responseText = json_encode($cliente);
            }
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = "Error: " . $e->getMessage();
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->get('/api/clientes', function (Request $request, Response $response) {
        $sqlConsult = "SELECT * FROM cliente";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->query($sqlConsult);
            if ($res->rowCount() > 0) {
                $clientes = $res->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($clientes);
            } else {
                $responseText = json_encode("No hay clientes en la bbdd");
            }

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/cliente/add', function (Request $request, Response $response) {
        $params = (array)$request->getParsedBody();
        
        $nombreCliente = $params['nombreCliente'];
        $direccionCliente = $params['direccionCliente'];
        $numTelCliente = $params['numTelCliente'];
        $passwordCliente = $params['passwordCliente'];


        $sqlConsult = "INSERT INTO cliente (cliente.nombreCliente, cliente.direccionCliente, cliente.numTelCliente, cliente.passwordCliente) VALUES (:nombreCliente, :direccionCliente, :numTelCliente, :passwordCliente)";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':nombreCliente', $nombreCliente);
            $res->bindParam(':direccionCliente', $direccionCliente);
            $res->bindParam(':numTelCliente', $numTelCliente);
            $res->bindParam(':passwordCliente', $passwordCliente);

            $res->execute();
            $responseText = json_encode("Cliente almacenado correctamente");
            
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->post('/api/cliente/update/{id}', function (Request $request, Response $response) {

        $idCliente = $request->getAttribute('id');

        $params = (array)$request->getParsedBody();
        
        $nombreCliente = $params['nombreCliente'];
        $direccionCliente = $params['direccionCliente'];
        $numTelCliente = $params['numTelCliente'];
        $passwordCliente = $params['passwordCliente'];


        $sqlConsult = "UPDATE cliente SET
        nombreCliente = :nombreCliente, 
        direccionCliente = :direccionCliente, 
        numTelCliente = :numTelCliente,
        passwordCliente = :passwordCliente 
        WHERE idCliente = $idCliente";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':nombreCliente', $nombreCliente);
            $res->bindParam(':direccionCliente', $direccionCliente);
            $res->bindParam(':numTelCliente', $numTelCliente);
            $res->bindParam(':passwordCliente', $passwordCliente);

            $res->execute();
            $responseText = json_encode("Cliente actualizado correctamente");
            
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/cliente/delete/{id}', function (Request $request, Response $response) {
        $idCliente = $request->getAttribute('id');
        $sqlConsult = "DELETE FROM cliente WHERE idCliente = $idCliente";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->execute();
            
            if($res->rowCount() > 0){
                $responseText = json_encode("Cliente eliminado correctamente");
            }else{
                $responseText = json_encode("No existe el cliente con ese ID");
            }
                
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    /* SECTION ARTICLE */

   


};
