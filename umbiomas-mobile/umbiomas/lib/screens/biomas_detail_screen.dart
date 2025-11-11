// lib/screens/biomas_detail_screen.dart
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:google_fonts/google_fonts.dart';
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
import 'package:umbiomas/theme/app_theme.dart'; // Importe o tema
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
      // O gradiente é aplicado ao fundo do Scaffold
      body: Container(
        decoration: BoxDecoration(gradient: AppTheme.backgroundGradient),
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
                    // Cor da AppBar já vem do tema
                    leading: Padding(
                      // Botão voltar estilizado
                      padding: const EdgeInsets.all(8.0),
                      child: CircleAvatar(
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
                      title: FittedBox(
                        // Título que encolhe
                        fit: BoxFit.scaleDown,
                        child: Text(
                          bioma.nome,
                          style: GoogleFonts.lato(
                            color: Colors.white,
                            fontSize: 18.0,
                            fontWeight: FontWeight.bold,
                            shadows: [
                              Shadow(
                                blurRadius: 4.0,
                                color: Colors.black.withOpacity(0.5),
                              ),
                            ],
                          ),
                        ),
                      ),
                      background: bioma.imagemUrl != null
                          ? Image.network(
                              bioma.imagemUrl!,
                              fit: BoxFit.cover,
                              // ... (loadingBuilder, errorBuilder) ...
                              frameBuilder: (context, child, frame, _) {
                                return Container(
                                  // Adiciona gradiente escuro
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

                  // Conteúdo da Página
                  SliverList(
                    delegate: SliverChildListDelegate([
                      SizedBox(height: 24),

                      // --- DESCRIÇÃO ---
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: Text(
                          "Descrição",
                          style: Theme.of(context).textTheme.titleLarge
                              ?.copyWith(fontWeight: FontWeight.bold),
                        ),
                      ),
                      SizedBox(height: 10),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: StyledContentBox(
                          // Usa o widget reutilizável
                          child: Text(
                            bioma.descricao ?? 'Descrição não disponível.',
                            textAlign: TextAlign.justify,
                            style: TextStyle(fontSize: 16, height: 1.5),
                          ),
                        ),
                      ),
                      SizedBox(height: 16),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: StyledContentBox(
                          // Usa o widget reutilizável
                          child: Center(
                            child: Text(
                              'População estimada: ${bioma.populacao ?? 0}',
                              style: Theme.of(context).textTheme.bodyLarge
                                  ?.copyWith(
                                    color: Theme.of(
                                      context,
                                    ).colorScheme.onPrimaryContainer,
                                    fontWeight: FontWeight.bold,
                                  ),
                            ),
                          ),
                        ),
                      ),

                      // --- MAPA ---
                      if (bioma.areaGeografica != null &&
                          bioma.areaGeografica!.isNotEmpty)
                        Padding(
                          padding: const EdgeInsets.fromLTRB(
                            16.0,
                            24.0,
                            16.0,
                            16.0,
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                "Área Geográfica",
                                style: Theme.of(context).textTheme.titleLarge
                                    ?.copyWith(fontWeight: FontWeight.bold),
                              ),
                              SizedBox(height: 10),
                              Container(
                                height: 300,
                                clipBehavior: Clip.antiAlias,
                                decoration: BoxDecoration(
                                  borderRadius: BorderRadius.circular(
                                    12.0,
                                  ), // Cantos arredondados no mapa
                                  boxShadow: [
                                    BoxShadow(
                                      color: Colors.grey.withOpacity(0.5),
                                      spreadRadius: 2,
                                      blurRadius: 5,
                                    ),
                                  ],
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
                                          'com.example.umbiomas', // Lembre de alterar
                                    ),
                                    PolygonLayer(
                                      polygons: [
                                        Polygon(
                                          points: bioma.areaGeografica!,
                                          color: Colors.blue.withOpacity(0.4),
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

                      SizedBox(height: 24),

                      // --- BOTÕES DE EXPLORAÇÃO ---
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0),
                        child: Text(
                          "Explorar Categorias:",
                          style: Theme.of(context).textTheme.titleLarge
                              ?.copyWith(fontWeight: FontWeight.bold),
                        ),
                      ),
                      SizedBox(height: 16),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.pets,
                        title: "Fauna",
                        type: Fauna,
                        fetch: ({search}) =>
                            apiService.fetchFauna(bioma.id, search: search),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.grass,
                        title: "Flora",
                        type: Flora,
                        fetch: ({search}) =>
                            apiService.fetchFlora(bioma.id, search: search),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.landscape,
                        title: "Relevo",
                        type: Relevo,
                        fetch: ({search}) =>
                            apiService.fetchRelevo(bioma.id, search: search),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.water,
                        title: "Hidrografia",
                        type: Hidrografia,
                        fetch: ({search}) => apiService.fetchHidrografia(
                          bioma.id,
                          search: search,
                        ),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.cloud,
                        title: "Clima",
                        type: Clima,
                        fetch: ({search}) =>
                            apiService.fetchClima(bioma.id, search: search),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.security,
                        title: "Áreas de Preservação",
                        type: AreaPreservacao,
                        fetch: ({search}) => apiService.fetchAreaPreservacao(
                          bioma.id,
                          search: search,
                        ),
                      ),
                      _buildCategoryButton(
                        context,
                        bioma: bioma,
                        icon: Icons.work,
                        title: "Socioeconomia",
                        type: CaracteristicaSe,
                        fetch: ({search}) => apiService.fetchCaracteristicaSe(
                          bioma.id,
                          search: search,
                        ),
                      ),

                      SizedBox(height: 24), // Espaço no final
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

  Widget _buildCategoryButton(
    BuildContext context, {
    required BiomaDetail bioma,
    required IconData icon,
    required String title,
    required Type type,
    required FetchFunction fetch,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 6.0),
      child: Card(
        elevation: 2.0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12.0),
        ),
        child: InkWell(
          borderRadius: BorderRadius.circular(12.0),
          onTap: () {
            Navigator.push(
              context,
              FadePageRoute(
                child: BiodiversityListScreen(
                  title: "$title - ${bioma.nome}", 
                  biomaId: bioma.id,
                  fetchFunction: fetch,
                  itemType: type,
                ),
              ),
            );
          },
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Row(
              children: [
                Icon(icon, color: AppTheme.primaryColor, size: 28),
                SizedBox(width: 16),
                Expanded(
                  child: Text(
                    title,
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.w600,
                      color: Colors.black87,
                    ),
                  ),
                ),
                Icon(Icons.chevron_right, color: Colors.grey),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
