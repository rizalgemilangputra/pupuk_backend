<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Clarifai\ClarifaiClient;
use Clarifai\Api\Data;
use Clarifai\Api\Image;
use Clarifai\Api\Input;
use Clarifai\Api\PostModelOutputsRequest;
use Clarifai\Api\Status\StatusCode;
use Exception;

class ClarifaiController extends Controller
{
    public function index(Request $request)
    {
        $client = ClarifaiClient::grpc();
        $metadata = ['Authorization' => ['Key e3bead918c954e7db63b74b8c7e2df83']];

        [$response, $status] = $client->PostModelOutputs(
            new PostModelOutputsRequest([
                'model_id' => 'color-recognition',  // This is the ID of the publicly available General model.
                'inputs' => [
                    new Input([
                        'data' => new Data([
                            'image' => new Image([
                                'url' => 'https://sawitindonesia.com/wp-content/uploads/2020/07/Culvularia-pdf-5-scaled.jpg'
                            ])
                        ])
                    ])
                ]
            ]),
            $metadata
        )->wait();

        if ($status->code !== 0) throw new Exception("Error: {$status->details}");
        if ($response->getStatus()->getCode() != StatusCode::SUCCESS) {
            throw new Exception("Failure response: " . $response->getStatus()->getDescription() . " " .
                $response->getStatus()->getDetails());
        }

        echo "<img src='https://sawitindonesia.com/wp-content/uploads/2020/07/Culvularia-pdf-5-scaled.jpg' height=250px>";
        echo "<br>";
        echo "<table border=1>
            <thead>
                <th>Hexa</th>
                <th>Color</th>
                <th>Percent</th>
            </thead>
            <tbody>";
        foreach ($response->getOutputs()[0]->getData()->getColors() as $color) {
            echo
            "<tr>
            <td>{$color->getW3c()->getHex()}</td>
            <td bgcolor=\"{$color->getW3c()->getHex()}\">{$color->getW3c()->getName()}</td>
            <td>{$color->getValue()}</td>
            </tr>";
        }
        echo"</tbody></table>";
    }
}
