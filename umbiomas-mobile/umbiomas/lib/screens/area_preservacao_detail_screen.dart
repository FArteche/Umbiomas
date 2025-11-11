// lib/screens/area_preservacao_detail_screen.dart
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:umbiomas/models/area_preservacao.dart';
import 'package:umbiomas/theme/app_theme.dart';
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
  late Future<AreaPreservacao> _itemDetailFuture; // Tipo específico

  @override
  void initState() {
    super.initState();
    _itemDetailFuture = apiService.fetchAreaPreservacaoDetail(widget.itemId);
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<AreaPreservacao>(
      future: _itemDetailFuture,
      builder: (context, snapshot) {
        String appBarTitle = 'Área de Preservação';
        AreaPreservacao? itemData; // Anulável

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle = itemData.nome;
        }

        return Scaffold(
          appBar: AppBar(title: Text(appBarTitle)), // Cor do tema
          body: Container(
            // Aplicando o gradiente de fundo
            decoration: BoxDecoration(gradient: AppTheme.backgroundGradient),
            child: Builder(
              builder: (context) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Center(child: CircularProgressIndicator());
                } else if (snapshot.hasError) {
                  return Center(child: Text('Erro: ${snapshot.error}'));
                } else if (!snapshot.hasData || itemData == null) {
                  return Center(child: Text('Detalhes não encontrados.'));
                } else {
                  // Extraindo dados
                  String title = itemData.nome;
                  String? tipoNome = itemData.tipo?.nome;
                  String? imageUrl = itemData.imagemUrl;
                  String? description = itemData.descricao;
                  LatLng? localizacao = itemData.localizacao;

                  return SingleChildScrollView(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        // Título
                        Text(
                          title,
                          textAlign: TextAlign.center,
                          style: Theme.of(context).textTheme.headlineMedium
                              ?.copyWith(fontWeight: FontWeight.bold),
                        ),
                        SizedBox(height: 24),

                        // Imagem
                        if (imageUrl != null)
                          ClipRRect(
                            borderRadius: BorderRadius.circular(12.0),
                            child: Image.network(
                              imageUrl,
                              height: 250,
                              width: double.infinity,
                              fit: BoxFit.cover,
                              errorBuilder: (c, e, s) => Container(
                                height: 250,
                                color: Colors.grey[200],
                                child: Icon(
                                  Icons.broken_image,
                                  size: 60,
                                  color: Colors.grey,
                                ),
                              ),
                            ),
                          )
                        else // Placeholder
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

                        // Tipo (Parque Nacional, etc.)
                        if (tipoNome != null)
                          Container(
                            width: double.infinity,
                            padding: EdgeInsets.symmetric(
                              vertical: 8.0,
                              horizontal: 12.0,
                            ),
                            decoration: BoxDecoration(
                              color: Colors.blue[50], // Fundo azul para "tipo"
                              borderRadius: BorderRadius.circular(8.0),
                              border: Border.all(color: Colors.blue[200]!),
                            ),
                            child: Text(
                              "Tipo: $tipoNome",
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                color: Colors.blue[800],
                                fontWeight: FontWeight.w500,
                                fontSize: 16,
                              ),
                            ),
                          ),
                        SizedBox(height: 16),

                        // Descrição
                        StyledContentBox(
                          child: Text(
                            description ?? 'Descrição não disponível.',
                            textAlign: TextAlign.justify,
                            style: Theme.of(
                              context,
                            ).textTheme.bodyLarge?.copyWith(height: 1.5),
                          ),
                        ),
                        SizedBox(height: 24),

                        // Mapa
                        if (localizacao != null)
                          StyledContentBox(
                            padding: const EdgeInsets.all(12.0),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.stretch,
                              children: [
                                Text(
                                  "Localização Aproximada",
                                  textAlign: TextAlign.center,
                                  style: Theme.of(context).textTheme.titleMedium
                                      ?.copyWith(
                                        fontWeight: FontWeight.bold,
                                        color: Colors.green[900],
                                      ),
                                ),
                                SizedBox(height: 12),
                                Container(
                                  height: 300,
                                  clipBehavior: Clip.antiAlias,
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(8.0),
                                  ),
                                  child: FlutterMap(
                                    options: MapOptions(
                                      initialCenter: localizacao,
                                      initialZoom: 13.0,
                                      interactionOptions: InteractionOptions(
                                        flags:
                                            InteractiveFlag.all &
                                            ~InteractiveFlag.rotate,
                                      ),
                                    ),
                                    children: [
                                      TileLayer(
                                        urlTemplate:
                                            'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                                        userAgentPackageName:
                                            'com.example.umbiomas', // TODO: Use o ID real
                                      ),
                                      MarkerLayer(
                                        markers: [
                                          Marker(
                                            point: localizacao,
                                            width: 80.0,
                                            height: 80.0,
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
                        SizedBox(height: 20),
                      ],
                    ),
                  );
                }
              },
            ),
          ),
        );
      },
    );
  }
}
