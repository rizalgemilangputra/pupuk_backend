<?php

namespace App\Models;

use Clarifai\Api\Data;
use Clarifai\Api\Image;
use Clarifai\Api\Input;
use Clarifai\Api\PostModelOutputsRequest;
use Clarifai\Api\Status\StatusCode;
use Clarifai\ClarifaiClient;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clarifai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clarifai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tanaman', 'hex', 'warna', 'nilai'
    ];

    /**
     * This is funtion to get date colors from clarifai api
     *
     * @param string $url_img
     *
     * @return object
     */
    static public function getData($url_img)
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
                                'url' => $url_img
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

        return $response->getOutputs()[0]->getData()->getColors();

        // echo "<img src='https://sawitindonesia.com/wp-content/uploads/2020/07/Culvularia-pdf-5-scaled.jpg' height=250px>";
        // echo "<br>";
        // echo "<table border=1>
        //     <thead>
        //         <th>Hexa</th>
        //         <th>Color</th>
        //         <th>Percent</th>
        //     </thead>
        //     <tbody>";
        // foreach ($response->getOutputs()[0]->getData()->getColors() as $color) {
        //     echo
        //     "<tr>
        //     <td>{$color->getW3c()->getHex()}</td>
        //     <td bgcolor=\"{$color->getW3c()->getHex()}\">{$color->getW3c()->getName()}</td>
        //     <td>{$color->getValue()}</td>
        //     </tr>";
        // }
        // echo"</tbody></table>";
    }
}
