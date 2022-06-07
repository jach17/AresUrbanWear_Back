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

            if ($res->rowCount() > 0) {
                $responseText = json_encode("Cliente eliminado correctamente");
            } else {
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

    $app->get('/api/articulo/{id}', function (Request $request, Response $response) {
        $idArticulo = $request->getAttribute('id');
        $sql = "SELECT * FROM articulo WHERE idArticulo = $idArticulo";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $articulo = $resultado->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($articulo);
            } else {
                $articulo = "No hay articulo con ese ID";
                $responseText = json_encode($articulo);
            }
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = "Error: " . $e->getMessage();
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->get('/api/articulos', function (Request $request, Response $response) {
        $sqlConsult = "SELECT * FROM articulo";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->query($sqlConsult);
            if ($res->rowCount() > 0) {
                $clientes = $res->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($clientes);
            } else {
                $responseText = json_encode("No hay articulos en la bbdd");
            }

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/articulo/add', function (Request $request, Response $response) {
        $params = (array)$request->getParsedBody();

        $descripcionArticulo = $params['descripcionArticulo'];
        $precioArticulo = $params['precioArticulo'];




        $sqlConsult = "INSERT INTO articulo 
        (articulo.descripcionArticulo, 
        articulo.precioArticulo) 
        VALUES (:descripcionArticulo, :precioArticulo)";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':descripcionArticulo', $descripcionArticulo);
            $res->bindParam(':precioArticulo', $precioArticulo);


            $res->execute();
            $responseText = json_encode("Articulo almacenado correctamente");

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->post('/api/articulo/update/{id}', function (Request $request, Response $response) {

        $idArticulo = $request->getAttribute('id');

        $params = (array)$request->getParsedBody();

        $descripcionArticulo = $params['descripcionArticulo'];
        $precioArticulo = $params['precioArticulo'];



        $sqlConsult = "UPDATE articulo SET
        descripcionArticulo = :descripcionArticulo, 
        precioArticulo = :precioArticulo
        WHERE idArticulo = $idArticulo";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':descripcionArticulo', $descripcionArticulo);
            $res->bindParam(':precioArticulo', $precioArticulo);

            $res->execute();
            $responseText = json_encode("Articulo actualizado correctamente");

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/articulo/delete/{id}', function (Request $request, Response $response) {
        $idArticulo = $request->getAttribute('id');
        $sqlConsult = "DELETE FROM articulo WHERE idCliente = $idArticulo";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->execute();

            if ($res->rowCount() > 0) {
                $responseText = json_encode("Articulo eliminado correctamente");
            } else {
                $responseText = json_encode("No existe el articulo con ese ID");
            }

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    /* SECTION PEDIDO */

    $app->get('/api/pedido/{id}', function (Request $request, Response $response) {
        $idPedido = $request->getAttribute('id');
        $sql = "SELECT * FROM pedido WHERE idPedido = $idPedido";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $pedido = $resultado->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($pedido);
            } else {
                $pedido = "No hay pedido con ese ID";
                $responseText = json_encode($pedido);
            }
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = "Error: " . $e->getMessage();
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->get('/api/pedidos', function (Request $request, Response $response) {
        $sqlConsult = "SELECT * FROM pedido";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->query($sqlConsult);
            if ($res->rowCount() > 0) {
                $pedidos = $res->fetchAll(PDO::FETCH_OBJ);
                $responseText = json_encode($pedidos);
            } else {
                $responseText = json_encode("No hay pedidos en la bbdd");
            }
            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/pedidos/add', function (Request $request, Response $response) {
        $params = (array)$request->getParsedBody();

        $idArticulo = $params['idArticulo'];
        $idCliente = $params['idCliente'];

        $sqlConsult = "INSERT INTO pedido 
                    (pedido.idArticulo, 
                    pedido.idCliente) 
                    VALUES (:idArticulo, :idCliente)";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':idArticulo', $idArticulo);
            $res->bindParam(':idCliente', $idCliente);


            $res->execute();
            $responseText = json_encode("Pedido almacenado correctamente");

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });

    $app->post('/api/pedido/update/{id}', function (Request $request, Response $response) {

        $idPedido = $request->getAttribute('id');

        $params = (array)$request->getParsedBody();

        $idArticulo = $params['idArticulo'];
        $idCliente = $params['idCliente'];



        $sqlConsult = "UPDATE pedido SET
                        idArticulo = :idArticulo, 
                        idCliente = :idCliente
                        WHERE idPedido = $idPedido";

        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->bindParam(':idArticulo', $idArticulo);
            $res->bindParam(':idCliente', $idCliente);

            $res->execute();
            $responseText = json_encode("Pedido actualizado correctamente");

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });


    $app->post('/api/pedido/delete/{id}', function (Request $request, Response $response) {
        $idPedido = $request->getAttribute('id');
        $sqlConsult = "DELETE FROM pedido WHERE idPedido = $idPedido";
        $responseText = "";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $res = $db->prepare($sqlConsult);
            $res->execute();

            if ($res->rowCount() > 0) {
                $responseText = json_encode("Pedido eliminado correctamente");
            } else {
                $responseText = json_encode("No existe el pedido con ese ID");
            }

            $res = null;
            $db = null;
        } catch (PDOException $e) {
            $responseText = json_encode("ERROR EN EL CATCH " . $e->getMessage());
        }

        $response->getBody()->write($responseText);
        return $response;
    });
};
