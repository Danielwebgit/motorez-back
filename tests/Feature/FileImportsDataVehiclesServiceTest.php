<?php

namespace Tests\Feature;

use App\Factories\FileImportsDataVehiclesFactory;
use App\Factories\SuppliersFactory;
use App\Models\Tenant;
use App\Services\FileImportsDataVehiclesService;
use App\Services\SuppliersService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class FileImportsDataVehiclesServiceTest extends TestCase
{

    protected function importsDataVehicleFactory(): FileImportsDataVehiclesService
    {
        return FileImportsDataVehiclesFactory::create();
    }

    protected function supplierFactory(): SuppliersService
    {
        return SuppliersFactory::create();
    }

    public function test_import_xml_file_for_tenants(): void
    {
        $tenant = \App\Models\Tenant::create(['name' => 'Test', 'domain' => 'test.localhost']);
        $tenant->domains()->create(['domain' => 'test.localhost']);

        \App\Models\Tenant::where('id', $tenant->id)->get()->runForEach(function () {
            
            Storage::fake('local');
            $data = UploadedFile::fake()->createWithContent('vehicles.xml', $this->getSampleXmlContent());

            $data = [ 'file' => $data ];

            $supplierService = $this->supplierFactory();
            $supplier = $supplierService->storeSupplier(['name' => 'Olx']);

            Request::merge(['suppliers_id' => $supplier->id]);
            
            $fileImportsDataVehiclesService = $this->importsDataVehicleFactory();
            $fileImportsDataVehiclesService->fileImportsDataVehicles($data);
            
            $this->assertDatabaseHas('vehicles', [
                'code' => '76926',
                'brand' => 'Toyota',
                'model' => 'Hilux',
            ]);

        });

        Tenant::find($tenant->id)->delete();
    }

    public function test_import_json_file_for_tenants(): void
    {
        $tenant = \App\Models\Tenant::create(['name' => 'Test', 'domain' => 'test.localhost']);
        $tenant->domains()->create(['domain' => 'test.localhost']);

        \App\Models\Tenant::where('id', $tenant->id)->get()->runForEach(function () {
            
            Storage::fake('local');
            $data = UploadedFile::fake()->createWithContent('vehicles.json', $this->getSampleJsonContent());

            $data = [ 'file' => $data ];

            $supplierService = $this->supplierFactory();
            $supplier = $supplierService->storeSupplier(['name' => 'Olx']);

            Request::merge(['suppliers_id' => $supplier->id]);
            
            $fileImportsDataVehiclesService = $this->importsDataVehicleFactory();
            $fileImportsDataVehiclesService->fileImportsDataVehicles($data);
            
            $this->assertDatabaseHas('vehicles', [
                'code' => '12345',
                'brand' => 'Chevrolet',
                'model' => 'Onix',
            ]);

        });

        Tenant::find($tenant->id)->delete();
    }

    

    private function getSampleXmlContent(): string
    {
        return <<<'XML'
                    <?xml version="1.0" encoding="UTF-8"?>
                    <estoque>
                    <veiculos>
                    <veiculo>
                        <codigoVeiculo>76926</codigoVeiculo>
                        <marca>Toyota</marca>
                        <modelo>Hilux</modelo>
                        <ano>2022</ano>
                        <versao>Standard</versao>
                        <cor>Branco</cor>
                        <quilometragem>103733</quilometragem>
                        <tipoCombustivel>GNV</tipoCombustivel>
                        <cambio>Automatica</cambio>
                        <portas>5</portas>
                        <precoVenda>107031.55</precoVenda>
                        <ultimaAtualizacao>13/11/2023 13:04</ultimaAtualizacao>
                        <opcionais>
                            <opcional>Central Multimídia</opcional>
                            <opcional>Bancos de Couro</opcional>
                            <opcional>Ar Condicionado</opcional>
                            <opcional>Vidros Eletricos</opcional>
                            <opcional>Sensor de Estacionamento</opcional>
                        </opcionais>
                    </veiculo>
                    <veiculo>
                        <codigoVeiculo>56974</codigoVeiculo>
                        <marca>Toyota</marca>
                        <modelo>Hilux</modelo>
                        <ano>2020</ano>
                        <versao>Trek</versao>
                        <cor>Branco</cor>
                        <quilometragem>91115</quilometragem>
                        <tipoCombustivel>Flex</tipoCombustivel>
                        <cambio>Manual</cambio>
                        <portas>5</portas>
                        <precoVenda>53029.02</precoVenda>
                        <ultimaAtualizacao>09/12/2023 13:04</ultimaAtualizacao>
                        <opcionais>
                            <opcional>Direcao Hidraulica</opcional>
                            <opcional>Central Multimídia</opcional>
                            <opcional>Câmera de Ré</opcional>
                        </opcionais>
                    </veiculo>
                    <veiculo>
                        <codigoVeiculo>16644</codigoVeiculo>
                        <marca>Fiat</marca>
                        <modelo>Argo</modelo>
                        <ano>2021</ano>
                        <versao>Trek</versao>
                        <cor>Branco</cor>
                        <quilometragem>149623</quilometragem>
                        <tipoCombustivel>Diesel</tipoCombustivel>
                        <cambio>Manual</cambio>
                        <portas>2</portas>
                        <precoVenda>70157.4</precoVenda>
                        <ultimaAtualizacao>16/07/2024 13:04</ultimaAtualizacao>
                        <opcionais>
                            <opcional>Central Multimídia</opcional>
                            <opcional>Direcao Hidraulica</opcional>
                            <opcional>Vidros Eletricos</opcional>
                            <opcional>Câmera de Ré</opcional>
                            <opcional>Sensor de Estacionamento</opcional>
                        </opcionais>
                    </veiculo>
                    </veiculos>
                    </estoque>
                    XML;
    }


   protected function getSampleJsonContent(): string
    {
        return json_encode([
            "veiculos" => [
                [
                    "id" => 12345,
                    "marca" => "Chevrolet",
                    "modelo" => "Onix",
                    "ano" => 2024,
                    "versao" => "LT",
                    "cor" => "Branco",
                    "km" => 10000,
                    "combustivel" => "Gasolina",
                    "cambio" => "Automático",
                    "portas" => 4,
                    "preco" => 85000.00,
                    "date" => "2024-06-11 19:30:21",
                    "opcionais" => [
                        "Ar condicionado",
                        "Vidros elétricos",
                        "Direção hidráulica",
                        "Travas elétricas"
                    ]
                ],
                [
                    "id" => 67890,
                    "marca" => "Fiat",
                    "modelo" => "Argo",
                    "ano" => 2023,
                    "versao" => "Trek",
                    "cor" => "Prata",
                    "km" => 20000,
                    "combustivel" => "Flex",
                    "cambio" => "Manual",
                    "portas" => 4,
                    "preco" => 72000.00,
                    "date" => "2024-06-14 07:20:41",
                    "opcionais" => [
                        "Ar condicionado",
                        "Vidros elétricos",
                        "Direção hidráulica"
                    ]
                ],
                [
                    "id" => 23456,
                    "marca" => "Volkswagen",
                    "modelo" => "T-Cross",
                    "ano" => 2022,
                    "versao" => "Comfortline",
                    "cor" => "Preto",
                    "km" => 30000,
                    "combustivel" => "Flex",
                    "cambio" => "Automático",
                    "portas" => 5,
                    "preco" => 98000.00,
                    "date" => "2024-06-14 09:15:01",
                    "opcionais" => [
                        "Ar condicionado",
                        "Vidros elétricos",
                        "Direção hidráulica",
                        "Teto solar",
                        "Faróis de LED"
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT);
    }
}
