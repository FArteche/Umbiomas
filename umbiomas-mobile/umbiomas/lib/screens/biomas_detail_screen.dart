import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart'; 
import 'package:latlong2/latlong.dart';    
import '../services/api_service.dart';
import '../models/bioma_detail.dart';

class BiomaDetailScreen extends StatefulWidget {
  final int biomaId; // Recebe o ID do bioma selecionado

  BiomaDetailScreen({required this.biomaId});

  @override
  _BiomaDetailScreenState createState() => _BiomaDetailScreenState();
}

class _BiomaDetailScreenState extends State<BiomaDetailScreen> {
  final ApiService apiService = ApiService();
  late Future<BiomaDetail> _biomaDetailFuture;

  @override
  void initState() {
    super.initState();
    // Inicia a busca pelos detalhes quando a tela é criada
    _biomaDetailFuture = apiService.fetchBiomaDetails(widget.biomaId);
  }

  // Função auxiliar para calcular os limites do polígono
  LatLngBounds? _calculateBounds(List<LatLng>? points) {
    if (points == null || points.isEmpty) return null;
    return LatLngBounds.fromPoints(points);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Detalhes do Bioma'),
        backgroundColor: Colors.green[700],
      ),
      body: FutureBuilder<BiomaDetail>(
        future: _biomaDetailFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Erro: ${snapshot.error}'));
          } else if (!snapshot.hasData) {
            return Center(child: Text('Detalhes do bioma não encontrados.'));
          } else {
            final bioma = snapshot.data!;
            final bounds = _calculateBounds(bioma.areaGeografica);

            return SingleChildScrollView( // Permite rolar a tela
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Imagem Principal
                  if (bioma.imagemUrl != null)
                    Image.network(
                      bioma.imagemUrl!,
                      width: double.infinity, // Ocupa toda a largura
                      height: 250,           // Altura fixa para a imagem
                      fit: BoxFit.cover,
                      errorBuilder: (context, error, stackTrace) => 
                        Container(height: 250, color: Colors.grey[300], child: Icon(Icons.broken_image)),
                    )
                  else // Imagem placeholder se não houver imagem
                    Container(
                      height: 250,
                      color: Colors.grey[300],
                      child: Center(child: Icon(Icons.terrain, size: 100, color: Colors.grey)),
                    ),
                  
                  // Conteúdo de Texto
                  Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          bioma.nome,
                          style: Theme.of(context).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.bold),
                        ),
                        SizedBox(height: 10),
                        if (bioma.populacao != null)
                          Text('População estimada: ${bioma.populacao}'), // Formate como desejar
                        SizedBox(height: 10),
                        Text(bioma.descricao ?? 'Descrição não disponível.'),
                      ],
                    ),
                  ),

                  // Mapa Leaflet
                  if (bioma.areaGeografica != null && bioma.areaGeografica!.isNotEmpty)
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 16.0),
                      child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                              Text("Área Geográfica", style: Theme.of(context).textTheme.titleLarge),
                              SizedBox(height: 10),
                              Container(
                                  height: 300, // Altura do container do mapa
                                  child: FlutterMap(
                                    options: MapOptions(
                                      initialCenter: bounds?.center ?? LatLng(-14.235, -51.925), // Centraliza no polígono ou no Brasil
                                      initialZoom: 4.0, // Zoom inicial padrão
                                      initialCameraFit: bounds != null ? CameraFit.bounds(bounds: bounds, padding: EdgeInsets.all(20)) : null, 
                                    ),
                                    children: [
                                      TileLayer(
                                        urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                                        userAgentPackageName: 'com.example.umbiomas', 
                                      ),
                                      PolygonLayer(
                                        polygons: [
                                          Polygon(
                                            points: bioma.areaGeografica!,
                                            color: Colors.blue.withOpacity(0.5),
                                            borderColor: Colors.blueAccent,
                                            borderStrokeWidth: 2,
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

                  // Botões para Listas Relacionadas
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 16.0),
                    child: Text("Explorar:", style: Theme.of(context).textTheme.titleLarge),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Wrap( // Wrap permite que os botões quebrem a linha se não couberem
                      spacing: 10, // Espaço horizontal
                      runSpacing: 10, // Espaço vertical
                      children: [
                        ElevatedButton.icon(
                          icon: Icon(Icons.pets),
                          label: Text("Fauna"),
                          onPressed: () { /* TODO: Navegar para tela da lista de Fauna */ },
                        ),
                        ElevatedButton.icon(
                          icon: Icon(Icons.grass),
                          label: Text("Flora"),
                          onPressed: () { /* TODO: Navegar para tela da lista de Flora */ },
                        ),
                        ElevatedButton.icon(
                          icon: Icon(Icons.landscape),
                          label: Text("Relevo"),
                          onPressed: () { /* TODO: Navegar para tela da lista de Relevo */ },
                        ),
                        // Adicione botões para Clima, Hidrografia, Características, Áreas Preserv.
                      ],
                    ),
                  ),
                  SizedBox(height: 20), // Espaço extra no final
                ],
              ),
            );
          }
        },
      ),
    );
  }
}