// lib/screens/fauna_flora_detail_screen.dart
import 'package:flutter/material.dart';
import 'package:umbiomas/theme/app_theme.dart';
import 'package:umbiomas/widgets/styled_content_box.dart';
import '../services/api_service.dart';

class FaunaFloraDetailScreen extends StatefulWidget {
  final int itemId;
  final String itemType; // "fauna" ou "flora"

  FaunaFloraDetailScreen({required this.itemId, required this.itemType});

  @override
  _FaunaFloraDetailScreenState createState() => _FaunaFloraDetailScreenState();
}

class _FaunaFloraDetailScreenState extends State<FaunaFloraDetailScreen> {
  final ApiService apiService = ApiService();
  late Future<dynamic> _itemDetailFuture;

  @override
  void initState() {
    super.initState();
    if (widget.itemType == 'fauna') {
      _itemDetailFuture = apiService.fetchFaunaDetail(widget.itemId);
    } else {
      _itemDetailFuture = apiService.fetchFloraDetail(widget.itemId);
    }
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<dynamic>(
      future: _itemDetailFuture,
      builder: (context, snapshot) {
        String appBarTitle = widget.itemType == 'fauna' ? 'Detalhes da Fauna' : 'Detalhes da Flora';
        dynamic itemData;

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle = itemData.nome ?? appBarTitle;
        }

        return Scaffold(
          appBar: AppBar(title: Text(appBarTitle)), // Cor do tema
          body: Container( // Aplicando o gradiente de fundo
            decoration: BoxDecoration(gradient: AppTheme.backgroundGradient),
            child: Builder(
              builder: (context) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Center(child: CircularProgressIndicator());
                } else if (snapshot.hasError) {
                  return Center(child: Text('Erro: ${snapshot.error}'));
                } else if (!snapshot.hasData) {
                  return Center(child: Text('Detalhes não encontrados.'));
                } else {
                  // Extraindo dados
                  String title = itemData.nome ?? 'Nome Indisponível';
                  String? subtitle = itemData.nomeCientifico;
                  String? family = itemData.familia;
                  String? imageUrl = itemData.imagemUrl;
                  String? description = itemData.descricao;
                  List<String> alsoPresentIn = itemData.tambemPresenteEm ?? [];

                  return SingleChildScrollView(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch, // Estica os filhos
                      children: [
                        // Título
                        Text(
                          title,
                          textAlign: TextAlign.center,
                          style: Theme.of(context).textTheme.headlineMedium?.copyWith(fontWeight: FontWeight.bold),
                        ),
                        SizedBox(height: 4),
                        
                        // Subtítulo (Nome Científico)
                        if (subtitle != null)
                          Text(
                            subtitle,
                            textAlign: TextAlign.center,
                            style: Theme.of(context).textTheme.titleMedium?.copyWith(
                                  fontStyle: FontStyle.italic,
                                  color: Colors.grey[700],
                                ),
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
                              errorBuilder: (c, e, s) => Container(height: 250, color: Colors.grey[200], child: Icon(Icons.broken_image, size: 60, color: Colors.grey)),
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
                            child: Center(child: Icon(Icons.image_not_supported, size: 60, color: Colors.grey)),
                          ),
                        SizedBox(height: 16),
                        
                        // Família (Usando StyledContentBox)
                        if (family != null)
                          StyledContentBox(
                            padding: EdgeInsets.symmetric(vertical: 8.0, horizontal: 12.0),
                            child: Text(
                              "Família: $family",
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                color: Colors.green[900],
                                fontWeight: FontWeight.w500,
                                fontSize: 16,
                              ),
                            ),
                          ),
                        SizedBox(height: 16),
                        
                        // "Também presente em"
                        if (alsoPresentIn.isNotEmpty)
                          StyledContentBox(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  "Também presente nos biomas:",
                                  style: Theme.of(context).textTheme.titleMedium
                                      ?.copyWith(fontWeight: FontWeight.bold, color: Colors.green[900]),
                                ),
                                SizedBox(height: 10),
                                Wrap(
                                  spacing: 8.0, runSpacing: 4.0,
                                  children: alsoPresentIn.map<Widget>((nomeBioma) {
                                    return Chip(
                                      label: Text(nomeBioma),
                                      backgroundColor: Colors.white,
                                      shape: StadiumBorder(side: BorderSide(color: Colors.green[200]!)),
                                    );
                                  }).toList(),
                                ),
                              ],
                            ),
                          ),
                        SizedBox(height: 16),
                        
                        // Descrição
                        StyledContentBox(
                          child: Text(
                            description ?? 'Descrição não disponível.',
                            textAlign: TextAlign.justify,
                            style: Theme.of(context).textTheme.bodyLarge?.copyWith(height: 1.5),
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