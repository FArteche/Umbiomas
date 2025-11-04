import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:umbiomas/models/area_preservacao.dart';
import 'package:umbiomas/models/caracteristica_se.dart';
import 'package:umbiomas/models/clima.dart';
import 'package:umbiomas/models/fauna.dart';
import 'package:umbiomas/models/flora.dart';
import 'package:umbiomas/models/hidrografia.dart';
import 'package:umbiomas/models/relevo.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/biodiversity_list_screen.dart';
import 'package:umbiomas/widgets/styled_content_box.dart';
import '../services/api_service.dart';
import '../models/bioma_detail.dart';

class BiomaDetailScreen extends StatefulWidget {
  final int biomaId;

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
    _biomaDetailFuture = apiService.fetchBiomaDetails(widget.biomaId);
  }

  LatLngBounds? _calculateBounds(List<LatLng>? points) {
    if (points == null || points.isEmpty) return null;
    return LatLngBounds.fromPoints(points);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightGreen[100]!, Colors.lightGreen[50]!],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: FutureBuilder<BiomaDetail>(
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
              return CustomScrollView(
                slivers: <Widget>[
                  SliverAppBar(
                    expandedHeight: 250.0,
                    floating: false,
                    pinned: true,
                    snap: false,
                    backgroundColor: Theme.of(context).colorScheme.primary,
                    leading: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: CircleAvatar(
                        // Cria o fundo circular
                        backgroundColor: Theme.of(
                          context,
                        ).colorScheme.primary.withOpacity(0.7),
                        child: IconButton(
                          icon: Icon(Icons.arrow_back, color: Colors.white),
                          onPressed: () => Navigator.of(context).pop(),
                          tooltip: 'Voltar',
                        ),
                      ),
                    ),
                    flexibleSpace: FlexibleSpaceBar(
                      centerTitle: true,
                      title: Text(
                        bioma.nome,
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 16.0,
                          fontWeight: FontWeight.bold,
                          shadows: [
                            Shadow(
                              blurRadius: 4.0,
                              color: Colors.black.withOpacity(0.5),
                            ),
                          ],
                        ),
                      ),
                      background: bioma.imagemUrl != null
                          ? Image.network(
                              bioma.imagemUrl!,
                              fit: BoxFit.cover,
                              loadingBuilder:
                                  (context, child, loadingProgress) {
                                    if (loadingProgress == null) return child;
                                    return Center(
                                      child: CircularProgressIndicator(),
                                    );
                                  },
                              errorBuilder: (context, error, stackTrace) =>
                                  Container(color: Colors.grey[400]),
                              frameBuilder:
                                  (context, child, frame, wasSyncLoaded) {
                                    return Container(
                                      decoration: BoxDecoration(
                                        gradient: LinearGradient(
                                          begin: Alignment.topCenter,
                                          end: Alignment.bottomCenter,
                                          colors: [
                                            Colors.transparent,
                                            Colors.black.withOpacity(0.7),
                                          ],
                                          stops: [0.5, 1.0],
                                        ),
                                      ),
                                      child: child,
                                    );
                                  },
                            )
                          : Container(color: Colors.grey[400]),
                    ),
                  ),
                  SliverList(
                    delegate: SliverChildListDelegate([
                      SizedBox(height: 20),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: Text(
                          "Explorar:",
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Wrap(
                          spacing: 10,
                          runSpacing: 10,
                          children: [
                            ElevatedButton.icon(
                              icon: Icon(Icons.water),
                              label: Text("Hidrografia"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<Hidrografia>(
                                      title: "Hidrografia - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchHidrografia(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.pets),
                              label: Text("Fauna"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<Fauna>(
                                      title: "Fauna - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchFauna(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.grass),
                              label: Text("Flora"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<Flora>(
                                      title: "Flora - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchFlora(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.sunny),
                              label: Text("Clima"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<Clima>(
                                      title: "Clima - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchClima(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.landscape),
                              label: Text("Relevo"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<Relevo>(
                                      title: "Relevo - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchRelevo(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.warning_rounded),
                              label: Text("Áreas de Preservação"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<AreaPreservacao>(
                                      title:
                                          "Areas de Preservação - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchAreaPreservacao(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                            ElevatedButton.icon(
                              icon: Icon(Icons.work_outlined),
                              label: Text("Características Socioeconômicas"),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  FadePageRoute(
                                    child: BiodiversityListScreen<CaracteristicaSe>(
                                      title:
                                          "Caracteristicas Socioeconômicas - ${bioma.nome}",
                                      biomaId: bioma.id,
                                      fetchFunction: ({String? search}) =>
                                          apiService.fetchCaracteristicaSe(
                                            bioma.id,
                                            search: search,
                                          ),
                                    ),
                                  ),
                                );
                              },
                            ),
                          ],
                        ),
                      ),
                      SizedBox(height: 20),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: Text(
                          "Descrição do Bioma ${bioma.nome}",
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                      ),
                      SizedBox(height: 10),
                      // Conteúdo de Texto
                      Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            if (bioma.populacao != null)
                              StyledContentBox(
                                child: Text(
                                  'População estimada: ${bioma.populacao}',
                                  style: Theme.of(context).textTheme.bodyLarge
                                      ?.copyWith(
                                        color: Theme.of(
                                          context,
                                        ).colorScheme.onPrimaryContainer,
                                      ),
                                ),
                              ),
                            SizedBox(height: 10),
                            Text(
                              bioma.descricao ?? 'Descrição não disponível.',
                            ),
                          ],
                        ),
                      ),

                      // Mapa Leaflet
                      if (bioma.areaGeografica != null &&
                          bioma.areaGeografica!.isNotEmpty)
                        Container(
                          // Use a cor 'primaryContainer' do seu tema
                          color: Theme.of(context).colorScheme.primaryContainer
                              .withOpacity(
                                0.3,
                              ), // Adicionei opacidade para suavizar
                          padding: const EdgeInsets.symmetric(
                            vertical: 24.0,
                          ), // Adiciona espaço vertical interno
                          child: Padding(
                            // O Padding original agora fica dentro do Container colorido
                            padding: const EdgeInsets.symmetric(
                              horizontal: 16.0,
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                SizedBox(
                                  // Garante que o Text ocupe toda a largura disponível
                                  width: double.infinity,
                                  child: Text(
                                    "Área Geográfica",
                                    textAlign:
                                        TextAlign.center, // Centraliza o texto
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
                                      initialCenter:
                                          bounds?.center ??
                                          LatLng(-14.235, -51.925),
                                      initialZoom: 4.0,
                                      initialCameraFit: bounds != null
                                          ? CameraFit.bounds(
                                              bounds: bounds,
                                              padding: EdgeInsets.all(20),
                                            )
                                          : null,
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
                                            'com.example.umbiomas',
                                      ),
                                      if (bioma.areaGeografica != null &&
                                          bioma.areaGeografica!.isNotEmpty)
                                        PolygonLayer(
                                          polygons: [
                                            Polygon(
                                              points: bioma.areaGeografica!,
                                              color: Colors.lightBlue
                                                  .withOpacity(0.1),
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
                        ),
                      SizedBox(height: 20),
                    ]),
                  ),
                ],
              );
            }
          },
        ),
      ),
    );
  }
}
