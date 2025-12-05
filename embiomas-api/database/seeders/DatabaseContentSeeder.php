<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bioma;
use App\Models\Fauna;
use App\Models\Flora;
use App\Models\Relevo;
use App\Models\Clima;
use App\Models\Tipo_CSE;
use App\Models\Caracteristica_SE;
use App\Models\Tipo_Area_Preservacao;
use App\Models\Area_Preservacao;
use App\Models\Hidrografia;
use App\Models\Info_Postador;
use App\Models\Post;
use App\Models\Sugestoes;

class DatabaseContentSeeder extends Seeder
{
    /**
     * Seed the application's content tables.
     */
    public function run(): void
    {
        // Usamos uma transação para garantir que tudo seja executado com sucesso ou nada seja salvo.
        DB::transaction(function () {
            /*
            // Desativa a verificação de chaves estrangeiras para poder limpar as tabelas
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Limpa as tabelas para evitar duplicatas ao rodar o seeder várias vezes
            Bioma::truncate();
            Fauna::truncate();
            Flora::truncate();
            Relevo::truncate();
            Clima::truncate();
            Tipo_CSE::truncate();
            Caracteristica_SE::truncate();
            Hidrografia::truncate();
            Info_Postador::truncate();
            Post::truncate();
            Sugestoes::truncate();
            Tipo_Area_Preservacao::truncate();
            Area_Preservacao::truncate();
            // Limpa as tabelas pivô
            DB::table('bioma_fauna')->truncate();
            DB::table('bioma_flora')->truncate();
            DB::table('bioma_clima')->truncate();
            // Adicione outras tabelas pivô aqui se necessário

            // Reativa a verificação de chaves estrangeiras
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            */
            // --- 1. CRIAR DADOS MESTRES (Fauna, Flora, Tipos, etc.) ---

            $fauna1 = Fauna::create([
                'nome_fauna' => 'Capivara',
                'nome_cientifico_fauna' => 'Hydrochoerus hydrochaeris',
                'familia_fauna' => 'Caviidae',
                'descricao_fauna' => 'O maior roedor do mundo, é um mamífero semi-aquático conhecido por viver em grupos nas margens de rios e lagos. Alimenta-se de capim e vegetação aquática, sendo uma figura comum em muitos ecossistemas sul-americanos.',
                'imagem_fauna' => 'seed_images/fauna/capivara.jpg'
            ]);
            $fauna2 = Fauna::create([
                'nome_fauna' => 'Tatu',
                'nome_cientifico_fauna' => 'Dasypus novemcinctus',
                'familia_fauna' => 'Dasypodidae',
                'descricao_fauna' => 'Mamífero noturno caracterizado por sua carapaça óssea dorsal que serve como proteção. É um excelente escavador, usando suas garras fortes para criar tocas e encontrar alimento, principalmente insetos.',
                'imagem_fauna' => 'seed_images/fauna/tatu.jpg'
            ]);
            $fauna3 = Fauna::create([
                'nome_fauna' => 'Onça-pintada',
                'nome_cientifico_fauna' => 'Panthera onca',
                'familia_fauna' => 'Felidae',
                'descricao_fauna' => 'O maior felino das Américas e o terceiro maior do mundo, é um predador topo de cadeia. Possui uma mordida excepcionalmente forte e sua pelagem é coberta por manchas em forma de rosetas, que servem como camuflagem.',
                'imagem_fauna' => 'seed_images/fauna/onca_pintada.jpg'
            ]);
            $fauna4 = Fauna::create([
                'nome_fauna' => 'Lobo-guará',
                'nome_cientifico_fauna' => 'Chrysocyon brachyurus',
                'familia_fauna' => 'Canidae',
                'descricao_fauna' => 'O maior canídeo da América do Sul, conhecido por suas pernas longas e finas, adaptadas para a vegetação alta do Cerrado. É onívoro, alimentando-se de pequenos animais e, crucialmente, do "fruto-do-lobo".',
                'imagem_fauna' => 'seed_images/fauna/lobo_guara.jpg'
            ]);
            $fauna5 = Fauna::create([
                'nome_fauna' => 'Arara-azul',
                'nome_cientifico_fauna' => 'Anodorhynchus hyacinthinus',
                'familia_fauna' => 'Psittacidae',
                'descricao_fauna' => 'A maior espécie de arara do mundo, facilmente reconhecível por sua plumagem de um azul-cobalto intenso e o anel amarelo ao redor dos olhos e na base do bico. Possui um bico extremamente forte, usado para quebrar sementes duras.',
                'imagem_fauna' => 'seed_images/fauna/arara_azul.jpg'
            ]);
            $fauna6 = Fauna::create([
                'nome_fauna' => 'Bicho-preguiça',
                'nome_cientifico_fauna' => 'Bradypus variegatus',
                'familia_fauna' => 'Bradypodidae',
                'descricao_fauna' => 'Mamífero arborícola de movimentos lentos, passa a maior parte da vida pendurado de cabeça para baixo nas árvores. Seu metabolismo é extremamente baixo e sua pelagem pode abrigar algas que ajudam na camuflagem.',
                'imagem_fauna' => 'seed_images/fauna/bicho_preguica.jpg'
            ]);
            $fauna7 = Fauna::create([
                'nome_fauna' => 'Tamanduá-bandeira',
                'nome_cientifico_fauna' => 'Myrmecophaga tridactyla',
                'familia_fauna' => 'Myrmecophagidae',
                'descricao_fauna' => 'Um grande mamífero insetívoro que não possui dentes. Usa seu focinho longo e uma língua pegajosa, que pode se estender por mais de 60 cm, para capturar formigas e cupins. Sua cauda grande e peluda é usada para se cobrir ao dormir.',
                'imagem_fauna' => 'seed_images/fauna/tamandua_bandeira.jpg'
            ]);
            $fauna8 = Fauna::create([
                'nome_fauna' => 'Jacaré-do-pantanal',
                'nome_cientifico_fauna' => 'Caiman yacare',
                'familia_fauna' => 'Alligatoridae',
                'descricao_fauna' => 'Espécie de jacaré encontrada em abundância no Pantanal. É um réptil carnívoro de porte médio, crucial para o equilíbrio ecológico dos corpos d\'água, alimentando-se de peixes, aves e outros animais.',
                'imagem_fauna' => 'seed_images/fauna/jacare_pantanal.jpg'
            ]);

            $flora1 = Flora::create([
                'nome_flora' => 'Araucária',
                'nome_cientifico_flora' => 'Araucaria angustifolia',
                'familia_flora' => 'Araucariaceae',
                'descricao_flora' => 'Também conhecida como Pinheiro-do-Paraná, é uma árvore conífera nativa da Mata Atlântica, especialmente comum no sul do Brasil. Sua semente, o pinhão, é um importante recurso alimentar para a fauna e para o consumo humano.',
                'imagem_flora' => 'seed_images/flora/araucaria.jpg'
            ]);
            $flora2 = Flora::create([
                'nome_flora' => 'Ipê-amarelo',
                'nome_cientifico_flora' => 'Handroanthus albus',
                'familia_flora' => 'Bignoniaceae',
                'descricao_flora' => 'Considerada a flor símbolo do Brasil, é famosa por sua espetacular floração amarela que ocorre geralmente no final do inverno, antes do surgimento das novas folhas. É uma árvore decídua de grande valor ornamental.',
                'imagem_flora' => 'seed_images/flora/ipe_amarelo.jpg'
            ]);
            $flora3 = Flora::create([
                'nome_flora' => 'Vitória-régia',
                'nome_cientifico_flora' => 'Victoria amazonica',
                'familia_flora' => 'Nymphaeaceae',
                'descricao_flora' => 'Planta aquática amazônica famosa por suas folhas circulares flutuantes gigantes, que podem atingir mais de 2,5 metros de diâmetro. Suas flores são grandes, brancas e desabrocham à noite, tornando-se rosadas no segundo dia.',
                'imagem_flora' => 'seed_images/flora/vitoria_regia.jpg'
            ]);
            $flora4 = Flora::create([
                'nome_flora' => 'Jequitibá-rosa',
                'nome_cientifico_flora' => 'Cariniana legalis',
                'familia_flora' => 'Lecythidaceae',
                'descricao_flora' => 'Uma árvore nativa da Mata Atlântica, considerada uma das maiores do Brasil, podendo atingir mais de 50 metros de altura e viver por séculos. É um símbolo da floresta primária e sua preservação é vital.',
                'imagem_flora' => 'seed_images/flora/jequitiba_rosa.jpg'
            ]);
            $flora5 = Flora::create([
                'nome_flora' => 'Cacto Mandacaru',
                'nome_cientifico_flora' => 'Cereus jamacaru',
                'familia_flora' => 'Cactaceae',
                'descricao_flora' => 'Cacto colunar de grande porte, é um símbolo do bioma Caatinga. Possui grande capacidade de armazenamento de água e é vital para a fauna local, servindo de alimento e abrigo. Suas grandes flores brancas desabrocham à noite.',
                'imagem_flora' => 'seed_images/flora/mandacaru.jpg'
            ]);
            $flora6 = Flora::create([
                'nome_flora' => 'Pau-brasil',
                'nome_cientifico_flora' => 'Paubrasilia echinata',
                'familia_flora' => 'Fabaceae',
                'descricao_flora' => 'Árvore nativa da Mata Atlântica que deu nome ao país. Historicamente explorada por sua madeira de cor vermelha intensa, usada para a fabricação de corantes e arcos de violino de alta qualidade. Hoje é uma espécie ameaçada.',
                'imagem_flora' => 'seed_images/flora/pau_brasil.jpg'
            ]);
            $flora7 = Flora::create([
                'nome_flora' => 'Copaíba',
                'nome_cientifico_flora' => 'Copaifera langsdorffii',
                'familia_flora' => 'Fabaceae',
                'descricao_flora' => 'Árvore de grande porte encontrada em diversos biomas, especialmente no Cerrado e Amazônia. É conhecida por produzir um óleo-resina (óleo de copaíba) extraído do tronco, amplamente utilizado na medicina popular por suas propriedades anti-inflamatórias e cicatrizantes.',
                'imagem_flora' => 'seed_images/flora/copaiba.jpg'
            ]);
            $flora8 = Flora::create([
                'nome_flora' => 'Buriti',
                'nome_cientifico_flora' => 'Mauritia flexuosa',
                'familia_flora' => 'Arecaceae',
                'descricao_flora' => 'Palmeira alta e elegante, típica de áreas úmidas e alagadas do Cerrado, Amazônia e Mata Atlântica, formando os chamados "buritizais". Seus frutos são ricos em vitamina A e usados para a produção de óleo, doces e bebidas.',
                'imagem_flora' => 'seed_images/flora/buriti.jpg'
            ]);

            $clima1 = Clima::create([
                'nome_clima' => 'Subtropical',
                'imagem_clima' => 'seed_images/clima/Subtropical.png',
                'descricao_clima' => 'Caracteriza-se por estações do ano bem definidas, com verões quentes e invernos mais frios que o restante do país, podendo registrar geadas. As chuvas são bem distribuídas ao longo do ano, sem uma estação seca definida.'
            ]);
            $clima2 = Clima::create([
                'nome_clima' => 'Tropical',
                'imagem_clima' => 'seed_images/clima/tropical.png',
                'descricao_clima' => 'Também conhecido como tropical sazonal, apresenta duas estações bem definidas: um verão quente e chuvoso, e um inverno ameno e seco. A maior parte da precipitação ocorre durante os meses de verão.'
            ]);
            $clima3 = Clima::create([
                'nome_clima' => 'Equatorial',
                'imagem_clima' => 'seed_images/clima/equatorial.png',
                'descricao_clima' => 'Predominante na região amazônica, caracteriza-se por temperaturas médias elevadas (acima de 25°C) e alta umidade. As chuvas são abundantes e constantes durante todo o ano, com um curto período de "seca" (menos chuvas).'
            ]);

            // --- 2. CRIAR OS BIOMAS ---

            $pampa = Bioma::create([
                'nome_bioma' => 'Pampa',
                'descricao_bioma' => 'Também conhecido como Campos Sulinos, é marcado por sua vegetação rasteira (gramíneas, herbáceas) e poucas árvores. É o bioma das grandes pastagens naturais, lar do tatu-mulita, do graxaim-do-campo e de aves migratórias.',
                'imagem_bioma' => 'seed_images/biomas/pampa.jpg',
                'populacao_bioma' => 4000000,
                'area_geografica' => [[-28.92163128242129, -58.53515625000001], [-30.221101852485987, -66.44531250000001], [-33.94335994657881, -70.13671875000001], [-39.09596293630548, -73.12500000000001], [-43.7710938177565, -71.45507812500001], [-50.233151832472245, -71.89453125000001], [-49.83798245308485, -67.06054687500001], [-43.13306116240613, -57.39257812500001], [-33.87041555094183, -50.36132812500001], [-28.6905876542507, -49.83398437500001], [-25.958044673317843, -52.646484375]]
            ]);
            $cerrado = Bioma::create([
                'nome_bioma' => 'Cerrado',
                'descricao_bioma' => 'Conhecido como a "caixa d\'água do Brasil" por abrigar as nascentes de importantes bacias hidrográficas. É a savana com a maior biodiversidade do mundo, caracterizada por árvores de tronco retorcido e casca grossa.',
                'imagem_bioma' => 'seed_images/biomas/cerrado.jpg',
                'populacao_bioma' => 24000000,
                'area_geografica' => [[-9.015302333420586, -65.65429687500001], [-14.26438308756265, -65.56640625000001], [-14.349547837185362, -61.61132812500001], [-17.476432197195518, -58.79882812500001], [-19.228176737766248, -56.16210937500001], [-16.214674588248542, -50.71289062500001], [-12.382928338487396, -47.90039062500001], [-7.100892668623642, -48.25195312500001], [-3.9519408561575817, -47.98828125000001]]
            ]);
            $amazonia = Bioma::create([
                'nome_bioma' => 'Amazônia',
                'descricao_bioma' => 'A maior floresta tropical do mundo, cobrindo a maior parte da Bacia Amazônica. É conhecida por sua biodiversidade incomparável, rios gigantescos e seu papel fundamental na regulação do clima global.',
                'imagem_bioma' => 'seed_images/biomas/amazonia.jpg',
                'populacao_bioma' => 30000000,
                'area_geografica' => [[3.6888551431470478, -64.07226562500001], [1.4939713066293239, -70.48828125000001], [-2.6357885741666065, -72.07031250000001], [-6.751896464843375, -74.88281250000001], [-10.746969318459989, -71.27929687500001], [-10.746969318459989, -63.63281250000001], [-9.79567758282973, -56.60156250000001], [-6.315298538330033, -51.767578125], [4.214943141390651, -53.876953125], [6.751896464843375, -58.44726562500001], [10.31491928581316, -62.40234375000001], [8.581021215641854, -71.80664062500001], [-1.4939713066293112, -71.89453125000001]]
            ]);
            $mataAtlantica = Bioma::create([
                'nome_bioma' => 'Mata Atlântica',
                'descricao_bioma' => 'Um dos biomas mais ricos em biodiversidade e, ao mesmo tempo, um dos mais ameaçados do planeta. Originalmente cobria toda a costa brasileira, hoje restando em fragmentos florestais que abrigam espécies endêmicas como o mico-leão-dourado.',
                'imagem_bioma' => 'seed_images/biomas/mata_atlantica.jpg',
                'populacao_bioma' => 70000000,
                'area_geografica' => [[-3.864254615721396, -41.57226562500001], [-8.494104537551882, -39.02343750000001], [-12.64033830684679, -40.95703125000001], [-18.396230138028812, -42.890625], [-22.268764039073968, -47.109375], [-28.22697003891834, -51.32812500000001], [-30.221101852485987, -51.32812500000001], [-31.05293398570515, -48.86718750000001], [-24.206889622398023, -45.3515625], [-22.512556954051437, -40.25390625000001], [-17.978733095556155, -38.23242187500001], [-12.64033830684679, -37.08984375000001], [-7.972197714386866, -33.75000000000001], [-2.284550660236957, -36.65039062500001]]
            ]);

            // --- 3. CRIAR DADOS QUE PERTENCEM A UM BIOMA (One-to-Many) ---

            Relevo::create([
                'nome_relevo' => 'Planície',
                'descricao_relevo' => 'Forma de relevo caracterizada por superfícies planas ou suavemente onduladas, geralmente em baixas altitudes, formadas por acúmulo de sedimentos. Exemplo: Planície do Pampa.',
                'tipo_relevo' => 'Planície',
                'imagem_relevo' => 'seed_images/relevo/planicie.jpg',
                'bioma_id' => $pampa->id_bioma
            ]);
            Relevo::create([
                'nome_relevo' => 'Chapada',
                'descricao_relevo' => 'Formação rochosa elevada, com uma porção superior relativamente plana (planalto) e bordas escarpadas (íngremes). É uma feição muito comum no bioma Cerrado, como a Chapada dos Veadeiros.',
                'tipo_relevo' => 'Chapada',
                'imagem_relevo' => 'seed_images/relevo/chapada.jpg',
                'bioma_id' => $cerrado->id_bioma
            ]);
            Relevo::create([
                'nome_relevo' => 'Depressão',
                'descricao_relevo' => 'Terreno plano ou côncavo situado em uma altitude mais baixa que as áreas ao seu redor. Na Amazônia, existem grandes áreas de depressão, como a Depressão Amazônica.',
                'tipo_relevo' => 'Depressão',
                'imagem_relevo' => 'seed_images/relevo/depressao.jpg',
                'bioma_id' => $amazonia->id_bioma
            ]);
            Relevo::create([
                'nome_relevo' => 'Serra',
                'descricao_relevo' => 'Conjunto de montanhas e terrenos acidentados com fortes desníveis. Na Mata Atlântica, exemplos notáveis incluem a Serra do Mar e a Serra da Mantiqueira.',
                'tipo_relevo' => 'Serra',
                'imagem_relevo' => 'seed_images/relevo/serra.jpg',
                'bioma_id' => $mataAtlantica->id_bioma
            ]);

            Hidrografia::create([
                'nome_hidrografia' => 'Rio Uruguai',
                'descricao_hidrografia' => 'Importante rio da Bacia Platina, que nasce na Serra Geral e serve como fronteira natural entre o Brasil (RS e SC) e a Argentina. É fundamental para a hidrografia do Pampa.',
                'tipo_hidrografia' => 'Rio',
                'imagem_hidrografia' => 'seed_images/hidrografia/rio_uruguai.jpg',
                'bioma_id' => 1
            ]);
            Hidrografia::create([
                'nome_hidrografia' => 'Rio Tocantins',
                'descricao_hidrografia' => 'Forma, junto com o Araguaia, a maior bacia hidrográfica inteiramente brasileira. Nasce no Cerrado (Goiás) e deságua próximo à foz do Rio Amazonas, sendo vital para a região.',
                'tipo_hidrografia' => 'Rio',
                'imagem_hidrografia' => 'seed_images/hidrografia/rio_tocantins.jpg',
                'bioma_id' => 2
            ]);
            Hidrografia::create([
                'nome_hidrografia' => 'Rio Amazonas',
                'descricao_hidrografia' => 'O maior rio do mundo em volume de água e extensão (considerando sua nascente nos Andes). É o eixo central da Bacia Amazônica, recebendo centenas de afluentes e abrigando uma imensa biodiversidade aquática.',
                'tipo_hidrografia' => 'Rio',
                'imagem_hidrografia' => 'seed_images/hidrografia/rio_amazonas.jpg',
                'bioma_id' => 3
            ]);
            Hidrografia::create([
                'nome_hidrografia' => 'Rio São Francisco',
                'descricao_hidrografia' => 'Conhecido como "Rio da Integração Nacional" ou "Velho Chico". Nasce no Cerrado (Serra da Canastra) e atravessa o bioma Caatinga, sendo vital para a vida e agricultura no semiárido nordestino.',
                'tipo_hidrografia' => 'Rio',
                'imagem_hidrografia' => 'seed_images/hidrografia/rio_sao_francisco.jpg',
                'bioma_id' => 4
            ]);

            $tipoCse1 = Tipo_CSE::create(['nome_tipocse' => 'Econômica']);
            $tipoCse2 = Tipo_CSE::create(['nome_tipocse' => 'Cultural']);

            Caracteristica_SE::create([
                'nome_cse' => 'Pecuária Extensiva',
                'descricao_cse' => 'Principal atividade econômica do Pampa, caracterizada pela criação de gado (bovino e ovino) em vastas áreas de pastagem natural. Moldou a cultura e a paisagem da região.',
                'bioma_id' => $pampa->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/pecuaria_extensiva.jpg',
                'tipocse_id' => $tipoCse1->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Festas Tradicionais',
                'descricao_cse' => 'A cultura do Pampa é marcada por fortes tradições gaúchas, celebradas em eventos como a Semana Farroupilha (que comemora a Revolução Farroupilha) e os rodeios, com música, dança (chula) e culinária (churrasco).',
                'bioma_id' => $pampa->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/festas_tradicionais.jpg',
                'tipocse_id' => $tipoCse2->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Agricultura Diversificada',
                'descricao_cse' => 'O Cerrado é considerado o "celeiro" do Brasil, sendo o principal produtor de grãos (soja, milho, feijão) e algodão, através da agricultura mecanizada e de alta tecnologia em grandes propriedades.',
                'bioma_id' => $cerrado->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/agricultura_diversificada.jpg',
                'tipocse_id' => $tipoCse1->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Culinária Típica',
                'descricao_cse' => 'A cultura do Cerrado é rica em sabores únicos, utilizando frutos nativos. Pratos como o arroz com pequi, pamonha, guariroba e o uso da castanha de baru são muito tradicionais na região.',
                'bioma_id' => $cerrado->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/culinaria_tipica.jpg',
                'tipocse_id' => $tipoCse2->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Extrativismo Sustentável',
                'descricao_cse' => 'Uma das principais atividades econômicas das comunidades ribeirinhas e tradicionais da Amazônia. Envolve a coleta de produtos florestais não madeireiros, como açaí, castanha-do-pará e látex da seringueira, de forma a preservar a floresta em pé.',
                'bioma_id' => $amazonia->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/extrativismo_sustentavel.jpg',
                'tipocse_id' => $tipoCse1->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Cultura Indígena',
                'descricao_cse' => 'A Amazônia abriga a maior diversidade de povos indígenas do Brasil. Essas comunidades possuem um profundo conhecimento da floresta, línguas próprias e tradições culturais ricas que são fundamentais para a identidade da região.',
                'bioma_id' => $amazonia->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/cultura_indigena.jpg',
                'tipocse_id' => $tipoCse2->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Turismo Ecológico',
                'descricao_cse' => 'Devido à sua beleza cênica (serras, praias, cachoeiras) e proximidade com grandes centros urbanos, a Mata Atlântica é um polo de ecoturismo, com foco em trilhas (trekking), observação de aves e visita a parques nacionais.',
                'bioma_id' => $mataAtlantica->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/turismo_ecologico.jpg',
                'tipocse_id' => $tipoCse1->id_tipocse
            ]);
            Caracteristica_SE::create([
                'nome_cse' => 'Patrimônio Histórico',
                'descricao_cse' => 'A Mata Atlântica foi o berço da colonização brasileira. Por isso, abriga cidades históricas de valor inestimável, como Paraty (RJ) e Ouro Preto (MG), que preservam a arquitetura e a arte do período colonial e imperial.',
                'bioma_id' => $mataAtlantica->id_bioma,
                'imagem_cse' => 'seed_images/caracteristica_se/patrimonio_historico.jpg',
                'tipocse_id' => $tipoCse2->id_tipocse
            ]);

            $tipoAp1 = Tipo_Area_Preservacao::create(['nome_tipoap' => 'Parque Nacional']);
            $tipoAp2 = Tipo_Area_Preservacao::create(['nome_tipoap' => 'Reserva Biológica']);

            Area_Preservacao::create([
                'nome_ap' => 'Parque Nacional da Lagoa do Peixe',
                'descricao_ap' => 'Localizado no litoral do Rio Grande do Sul (bioma Pampa), é um sítio de importância internacional. A lagoa é uma parada crucial para aves migratórias que viajam do Hemisfério Norte para a Patagônia.',
                'bioma_id' => $pampa->id_bioma,
                'tipoap_id' => $tipoAp1->id_tipoap,
                'imagem_ap' => 'seed_images/area_preservacao/lagoa_do_peixe.jpg',
                'area_geografica' => ["lat" => -32.25926542645934, "lng" => -52.43774414062501]
            ]);
            Area_Preservacao::create([
                'nome_ap' => 'Parque Nacional da Chapada dos Veadeiros',
                'descricao_ap' => 'Situado no bioma Cerrado, em Goiás, este parque é Patrimônio Mundial da UNESCO. É famoso por seus cânions, cachoeiras com mais de 100 metros e formações de quartzo que atraem turistas místicos.',
                'bioma_id' => $cerrado->id_bioma,
                'tipoap_id' => $tipoAp1->id_tipoap,
                'imagem_ap' => 'seed_images/area_preservacao/chapada_dos_veadeiros.jpg',
                'area_geografica' => ["lat" => -12.211180191503997, "lng" => -63.72070312500001]
            ]);
            Area_Preservacao::create([
                'nome_ap' => 'Reserva Biológica do Cobre e Associados',
                'descricao_ap' => 'Unidade de conservação de proteção integral no bioma Amazônia. O objetivo é a preservação total dos ecossistemas, sendo permitida a visitação apenas com fins educacionais ou de pesquisa científica.',
                'bioma_id' => $amazonia->id_bioma,
                'tipoap_id' => $tipoAp2->id_tipoap,
                'imagem_ap' => 'seed_images/area_preservacao/reserva_cobre.jpg',
                'area_geografica' => ["lat" => -5.615985819155327, "lng" => -64.42382812500001]
            ]);
            Area_Preservacao::create([
                'nome_ap' => 'Parque Nacional da Serra dos Órgãos',
                'descricao_ap' => 'Localizado na Mata Atlântica, no estado do Rio de Janeiro. É famoso por suas trilhas e formações rochosas impressionantes, como o "Dedo de Deus". É um dos principais destinos de montanhismo e trekking do país.',
                'bioma_id' => $mataAtlantica->id_bioma,
                'tipoap_id' => $tipoAp1->id_tipoap,
                'imagem_ap' => 'seed_images/area_preservacao/serra_dos_orgaos.jpg',
                'area_geografica' => ["lat" => -22.268764039073968, "lng" => -44.03320312500001]
            ]);


            // --- 4. ASSOCIAR DADOS (Many-to-Many) ---

            // Associações para o Pampa
            $pampa->fauna()->attach([$fauna1->id_fauna, $fauna2->id_fauna]);
            $pampa->clima()->attach($clima1->id_clima);
            $pampa->flora()->attach([$flora1->id_flora, $flora6->id_flora]);

            // Associações para o Cerrado
            $cerrado->fauna()->attach([$fauna4->id_fauna, $fauna7->id_fauna]);
            $cerrado->flora()->attach([$flora5->id_flora, $flora7->id_flora]);
            $cerrado->clima()->attach($clima2->id_clima);

            // Associações para a Amazônia
            $amazonia->fauna()->attach([$fauna3->id_fauna, $fauna5->id_fauna, $fauna6->id_fauna, $fauna8->id_fauna]);
            $amazonia->flora()->attach([$flora3->id_flora, $flora4->id_flora, $flora8->id_flora]);
            $amazonia->clima()->attach($clima3->id_clima);

            // Associações para a Mata Atlântica
            $mataAtlantica->fauna()->attach([$fauna1->id_fauna, $fauna3->id_fauna]);
            $mataAtlantica->flora()->attach([$flora1->id_flora, $flora2->id_flora]);
            $mataAtlantica->clima()->attach([$clima1->id_clima, $clima2->id_clima]);
        });
    }
}
