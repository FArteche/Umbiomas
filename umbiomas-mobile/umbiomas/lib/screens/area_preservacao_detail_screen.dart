import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:umbiomas/models/area_preservacao.dart';
import 'package:umbiomas/widgets/styled_content_box.dart';
import '../services/api_service.dart';

class AreaPreservacaoDetailScreen extends StatefulWidget {
  final int itemId;

  AreaPreservacaoDetailScreen({required this.itemId});

  @override
  _AreaPreservacaoDetailScreenState createState() =>
      _AreaPreservacaoDetailScreenState();
}

class _AreaPreservacaoDetailScreenState
    extends State<AreaPreservacaoDetailScreen> {
  final ApiService apiService = ApiService();
  late Future<dynamic> _itemDetailFuture;

  @override
  void initState() {
    super.initState();
    _itemDetailFuture = apiService.fetchAreaPreservacaoDetail(widget.itemId);
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<dynamic>(
      future: _itemDetailFuture,
      builder: (context, snapshot) {
        String appBarTitle = 'Área de Preservação';
        AreaPreservacao itemData;

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle = itemData.nome;
        }

        return Scaffold(
          appBar: AppBar(title: Text(appBarTitle)),
          body: Builder(
            // Usamos Builder para garantir acesso ao context correto do Scaffold
            builder: (context) {
              // Estados de carregamento e erro
              if (snapshot.connectionState == ConnectionState.waiting) {
                return Center(child: CircularProgressIndicator());
              } else if (snapshot.hasError) {
                return Center(
                  child: Text('Erro ao carregar detalhes: ${snapshot.error}'),
                );
              } else if (!snapshot.hasData) {
                return Center(child: Text('Detalhes não encontrados.'));
              } else {
                itemData = snapshot.data;

                return SingleChildScrollView(
                  padding: const EdgeInsets.all(16.0), // Espaçamento geral
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment
                        .center, // Centraliza os itens horizontalmente
                    children: [
                      // Nome Principal
                      Text(
                        itemData.nome,
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.headlineMedium
                            ?.copyWith(fontWeight: FontWeight.bold),
                      ),
                      SizedBox(height: 24), // Espaço maior antes da imagem
                      // Container da Imagem (Similar ao do Mapa)
                      if (itemData.imagemUrl != null)
                        Container(
                          height: 250, // Altura da imagem
                          width: double.infinity, // Ocupa a largura
                          clipBehavior: Clip.antiAlias,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(
                              12.0,
                            ), // Cantos arredondados
                            color: Theme.of(context)
                                .colorScheme
                                .primaryContainer
                                .withOpacity(0.3), // Fundo suave do tema
                          ),
                          child: Image.network(
                            itemData.imagemUrl ??
                                'https://upload.wikimedia.org/wikipedia/commons/5/55/Broken_image.png',
                            fit: BoxFit.cover,
                            loadingBuilder: (context, child, progress) {
                              if (progress == null) return child;
                              return Center(child: CircularProgressIndicator());
                            },
                            errorBuilder: (context, error, stackTrace) =>
                                Center(
                                  child: Icon(
                                    Icons.broken_image,
                                    size: 60,
                                    color: Colors.grey,
                                  ),
                                ),
                          ),
                        )
                      else // Placeholder se não houver imagem
                        Container(
                          height: 250,
                          width: double.infinity,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(12.0),
                            color: Colors.grey[200],
                          ),
                          child: Center(
                            child: Icon(
                              Icons.image_not_supported,
                              size: 60,
                              color: Colors.grey,
                            ),
                          ),
                        ),
                      SizedBox(height: 16),
                      // Descrição
                      StyledContentBox(
                        child: Text(
                          itemData.descricao ?? 'Descrição não disponível.',
                          textAlign: TextAlign.justify,
                          style: Theme.of(context).textTheme.bodyLarge,
                        ),
                      ),
                      SizedBox(height: 20), // Espaço no final
                      if (itemData.localizacao != null)
                        Container(
                          decoration: BoxDecoration(
                            color: Colors.green[50],
                            border: Border.all(
                              color: Colors.green[200]!,
                              width: 1.5,
                            ),
                            borderRadius: BorderRadius.circular(5.0),
                          ),
                          padding: const EdgeInsets.symmetric(vertical: 24.0),
                          child: Padding(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 16.0,
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                SizedBox(
                                  width: double.infinity,
                                  child: Text(
                                    "Localização Aproximada",
                                    textAlign:
                                        TextAlign.center, // Centraliza o título
                                    style: Theme.of(context)
                                        .textTheme
                                        .titleLarge
                                        ?.copyWith(
                                          color: Theme.of(
                                            context,
                                          ).colorScheme.onPrimaryContainer,
                                        ),
                                  ),
                                ),
                                SizedBox(height: 10),
                                Container(
                                  height: 400,
                                  clipBehavior: Clip.antiAlias,
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(8.0),
                                  ),
                                  child: FlutterMap(
                                    options: MapOptions(
                                      initialCenter: itemData.localizacao!,
                                      initialZoom: 8.0,
                                      interactionOptions: InteractionOptions(
                                        flags:
                                            InteractiveFlag.all &
                                            ~InteractiveFlag
                                                .rotate, // Desabilita rotação
                                      ),
                                    ),
                                    children: [
                                      TileLayer(
                                        urlTemplate:
                                            'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                                        userAgentPackageName:
                                            'com.example.umbiomas',
                                      ),
                                      MarkerLayer(
                                        markers: [
                                          Marker(
                                            point: itemData
                                                .localizacao!, // Ponto onde o marcador ficará
                                            width:
                                                80.0, // Largura do widget do marcador
                                            height:
                                                80.0, // Altura do widget do marcador
                                            child: Icon(
                                              Icons.location_pin,
                                              color: Colors.red,
                                              size: 40.0,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        SizedBox(height: 10,)
                    ],
                  ),
                );
              }
            },
          ),
        );
      },
    );
  }
}
