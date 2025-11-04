<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bioma; // Importe o seu Model Bioma

class BiomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bioma::create([
            'nome_bioma' => 'Pampa',
            'descricao_bioma' => 'O Pampa é uma região natural e pastoril de planícies com coxilhas cobertas por campos localizada no sul da América do Sul. Geograficamente abrange a metade meridional do estado brasileiro do Rio Grande do Sul (ocupando cerca de 69% do território do estado), o Uruguai e as províncias argentinas de Buenos Aires, La Pampa, Santa Fé, Córdoba, Entre Ríos e Corrientes.
            No âmbito brasileiro, os pampas podem ser designados com o termo regionalista campanha gaúcha. Quando em conjunto com os campos do planalto meridional (abrangendo regiões do norte do Rio Grande do Sul, Santa Catarina e Paraná, incluindo os Campos de Cima da Serra e os Campos Gerais do Paraná), são chamados campos do sul ou campos sulinos.
            Etimologia e conceito. "Pampa" originou-se do vocábulo pampa, de origem aimará e quéchua, que significa "planície". "Campos" é oriundo do termo latino campv, campus. "Campanha" é oriundo do termo latino tardio campania, que possui também o significado de planície.

            A terminologia relacionada à região dos campos sulinos do Brasil varia entre diferentes autores. Na classificação dos "biomas" (mais propriamente, domínios) brasileiros pelo IBGE (2004), tal região está subdividida entre os biomas Mata Atlântica (planalto meridional, ou planalto das araucárias, do Paraná ao Rio Grande do Sul) e Pampa (sul do Rio Grande do Sul).
            Fitogeograficamente, para Cabrera & Willink (1973, 1980), os campos sulinos estão dentro da Região Neotropical, subdivididos entre a Província Paranaense (no Domínio Amazônico) e a Província Pampeana (no Domínio Chaqueno).O IBGE (2012) denomina estas duas regiões florísticas como região dos campos do planalto meridional e região da campanha gaúcha.
            Em termos de tipo de vegetação, no Projeto Radambrasil (Veloso & Góes-Filho, 1982), precursor dos esquemas de vegetação do IBGE, os campos gerais do planalto meridional, são descritos como um tipo de savana, enquanto os campos da campanha gaúcha são descritos como um tipo de estepe.
            Posteriormente, os sistemas do IBGE (2012) aplicariam o termo estepe a ambos os campos. Entretanto, alguns autores consideram o uso do termo "estepe" para descrever o tipo de vegetação da região dos campos sulinos em desacordo com o uso na literatura internacional de tal expressão, preferindo usar o termo tradicional "campos". ',
            'populacao_bioma' => 30000000,
        ]);

        Bioma::create([
            'nome_bioma' => 'Mata Atlântica',
            'descricao_bioma' => 'A Mata Atlântica é um bioma de floresta tropical que abrange a costa leste, nordeste, sudeste e sul do Brasil, leste do Paraguai e a província de Misiones, na Argentina. Seus processos ecológicos evoluíram a partir do Eoceno, quando os continentes já estavam relativamente dispostos como estão hoje. A região é ocupada por seres humanos há mais de 10 000 anos. A partir da colonização europeia, e principalmente, no século XX, a Mata Atlântica passou por intenso desmatamento, restando menos de 20% da cobertura vegetal original.
            É um grande centro de endemismo e suas formações vegetais são extremamente heterogêneas, indo desde campos abertos em regiões montanhosas até florestas chuvosas perenes nas terras baixas do litoral. A fauna abriga diversas espécies endêmicas, e muitas são carismáticas, como o mico-leão-dourado e a onça-pintada. O WWF dividiu a Mata Atlântica em 15 ecorregiões, visando manter ações mais regionalizadas na conservação, já que o grau de desmatamento e as ações conservacionistas são específicas para cada região abrangida pelo bioma. Atualmente, cerca de 16% da cobertura original existe, a maior parte em pequenos fragmentos, de floresta secundária. No Brasil, restam cerca de 15,3% (a maior parte na Serra do Mar), no Paraguai, cerca de 15% e na Argentina, 45% da vegetação. Na conservação da Mata Atlântica brasileira, a criação de dois corredores ecológicos ligando os principais remanescentes de floresta no sul da Bahia e norte do Espírito Santo (Corredor Central) e os fragmentos na região da Serra do Mar e da Serra dos Órgãos (Corredor da Serra Mar) são de suma importância na conservação da biodiversidade.
            Os remanescentes do Paraguai e Argentina fazem parte de uma estratégia trinacional de conservação, com a criação de corredores unindo as principais unidades de conservação desses países e outras quatro unidades de conservação do Brasil. Na Argentina, restam cerca de 10 000 km², o que representa o maior trecho contínuo de "mata Atlântica do Interior". A Lei do Corredor Verde é uma tentativa de resguardar legalmente esses pedaços de floresta na Argentina. No Paraguai, o desmatamento se deu principalmente a partir da década de 1980 e as unidades de conservação são poucas e na maior parte particulares. Apesar do alto grau de desmatamento, a região da Mata Atlântica é a que mais possui unidades de conservação na América Latina, apesar de muitas serem pequenas e insuficientes para manutenção de processos ecológicos e biodiversidade. ',
            'populacao_bioma' => 145000000,
        ]);

        Bioma::create([
            'nome_bioma' => 'Amazônia',
            'descricao_bioma' => 'A maior floresta tropical do mundo, cobrindo a maior parte da Bacia Amazônica na América do Sul. É conhecida por sua vasta biodiversidade e papel crucial na regulação do clima global.',
            'populacao_bioma' => 30000000,
        ]);
    }
}
