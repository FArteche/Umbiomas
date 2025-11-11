// lib/screens/hidro_relevo_detail_screen.dart
import 'package:flutter/material.dart';
import 'package:umbiomas/theme/app_theme.dart';
import 'package:umbiomas/widgets/styled_content_box.dart';
import '../services/api_service.dart';

class HidroRelevoDetailScreen extends StatefulWidget {
  final int itemId;
  final String itemType; // "hidrografia" ou "relevo"

  HidroRelevoDetailScreen({required this.itemId, required this.itemType});

  @override
  _HidroRelevoDetailScreenState createState() =>
      _HidroRelevoDetailScreenState();
}

class _HidroRelevoDetailScreenState extends State<HidroRelevoDetailScreen> {
  final ApiService apiService = ApiService();
  late Future<dynamic> _itemDetailFuture;

  @override
  void initState() {
    super.initState();
    if (widget.itemType == 'hidrografia') {
      _itemDetailFuture = apiService.fetchHidrografiaDetail(widget.itemId);
    } else {
      _itemDetailFuture = apiService.fetchRelevoDetail(widget.itemId);
    }
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<dynamic>(
      future: _itemDetailFuture,
      builder: (context, snapshot) {
        String appBarTitle = widget.itemType == 'relevo'
            ? 'Detalhes do Relevo'
            : 'Detalhes da Hidrografia';
        dynamic itemData;

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle = itemData.nome ?? appBarTitle;
        }

        return Scaffold(
          appBar: AppBar(title: Text(appBarTitle)), // Cor do tema
          body: Container(
            decoration: BoxDecoration(gradient: AppTheme.backgroundGradient),
            height: double.infinity,
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
                  String? type = itemData.tipo;
                  String? imageUrl = itemData.imagemUrl;
                  String? description = itemData.descricao;

                  return SingleChildScrollView(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.stretch, // Estica os filhos
                      children: [
                        // Título
                        Text(
                          title,
                          textAlign: TextAlign.center,
                          style: Theme.of(context).textTheme.headlineMedium
                              ?.copyWith(fontWeight: FontWeight.bold),
                        ),
                        SizedBox(height: 4),

                        // Subtítulo (Tipo)
                        if (type != null)
                          Text(
                            type,
                            textAlign: TextAlign.center,
                            style: Theme.of(context).textTheme.titleMedium
                                ?.copyWith(
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
                        SizedBox(height: 24),

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
