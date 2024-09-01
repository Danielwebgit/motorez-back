<?php

namespace App\Services;

use App\Jobs\ProcessVehiclesJob;
use App\Repositories\Eloquents\VehiclesRepository;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Request;

class FileImportsDataVehiclesService
{
    public function __construct(
        private VehiclesRepository $vehicleRepository
    ) {}

    public function fileImportsDataVehicles($data)
    {
        $batchSize = 10;

        $file = $data->file('file');
        $extension = $file->getClientOriginalExtension();
        $data = [];

        if ($extension == 'json') {
            $data = json_decode(file_get_contents($file), true);
        } elseif ($extension == 'xml') {
            $xml = simplexml_load_file($file);
            $data = json_decode(json_encode($xml), true);
        }

        $veiculoDatas = $this->ProcessXmlAndJsonDataToTheBankStandard($data);
        ProcessVehiclesJob::dispatch($veiculoDatas, $batchSize);
    }

    public function processXmlAndJsonDataToTheBankStandard($data)
    {
        $veiculos = $data['veiculos']['veiculo'] ?? $data['veiculos'] ?? [];

        $veiculoData = [];

        $suppliersId = Request::query('suppliers_id');

        foreach ($veiculos as $key => $veiculo) {

            $veiculoData[] = [
                'code' => $veiculo['id'] ?? $veiculo['codigoVeiculo'] ?? null,
                'brand' => $veiculo['marca'] ?? $veiculo['marca'] ?? null,
                'model' => $veiculo['modelo'] ?? $veiculo['modelo'] ?? null,
                'year' => $veiculo['ano'] ?? $veiculo['year'] ?? null,
                'version' => $veiculo['versao'] ?? null,
                'mileage' => $veiculo['km'] ?? $veiculo['quilometragem'] ?? null,
                'fuel' => $veiculo['combustivel'] ?? $veiculo['tipoCombustivel'] ?? null,
                'doors' => $veiculo['portas'] ?? null,
                'price' => $veiculo['preco'] ?? $veiculo['precoVenda'] ?? null,
                'date' => $veiculo['date'] ?? $this->convertDateFormatToTimestamp($veiculo['ultimaAtualizacao']) ?? null,
                'suppliers_id' => $suppliersId
            ];

            $this->checkRequiredAttributes($veiculoData[$key]);
        }

        return $veiculoData;
    }

    public function convertDateFormatToTimestamp($dateTime)
    {
        $dateObject = DateTime::createFromFormat('d/m/Y H:i', $dateTime);

        if ($dateObject === false) {
            throw new Exception("Formato de data inválido");
        }

        return $dateObject->format('Y-m-d H:i:s');
    }

    public function checkRequiredAttributes(array $veiculoData): bool
    {
        return $veiculoData['brand'] && $veiculoData['model'] && $veiculoData['year'] &&
            $veiculoData['fuel'] && $veiculoData['price'] && $veiculoData['mileage'];
    }
}
