import 'package:flutter/material.dart';
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
        String appBarTitle = widget.itemType == 'fauna'
            ? 'Detalhes da Fauna'
            : 'Detalhes da Flora';
        dynamic itemData;

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle = itemData.nome ?? appBarTitle;
        }

        return Scaffold(
          appBar: AppBar(title: Text(appBarTitle)),
          body: Builder(
            builder: (context) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return Center(child: CircularProgressIndicator());
              } else if (snapshot.hasError) {
                return Center(
                  child: Text('Erro ao carregar detalhes: ${snapshot.error}'),
                );
              } else if (!snapshot.hasData) {
                return Center(child: Text('Detalhes não encontrados.'));
              } else {
                String title = itemData.nome ?? 'Nome Indisponível';
                String? subtitle = itemData.nomeCientifico;
                String? family = itemData.familia;
                String? imageUrl = itemData.imagemUrl;
                String? description = itemData.descricao;
                List<String> alsoPresentIn = itemData.tambemPresenteEm;

                return SingleChildScrollView(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Text(
                        title,
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.headlineMedium
                            ?.copyWith(fontWeight: FontWeight.bold),
                      ),
                      SizedBox(height: 4),
                      if (subtitle != null)
                        Text(
                          subtitle,
                          textAlign: TextAlign.center,
                          style: Theme.of(context).textTheme.titleMedium
                              ?.copyWith(
                                fontStyle: FontStyle.italic,
                                color: Colors.grey[600], // Cor mais clara
                              ),
                        ),
                      SizedBox(height: 24), // Espaço maior antes da imagem
                      // Container da Imagem (Similar ao do Mapa)
                      if (imageUrl != null)
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
                            imageUrl,
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

                      // Família (Com fundo verde claro)
                      if (family != null)
                        Container(
                          width: double.infinity, // Ocupa a largura
                          padding: EdgeInsets.symmetric(
                            vertical: 8.0,
                            horizontal: 12.0,
                          ),
                          decoration: BoxDecoration(
                            color: Colors.green[50], // Fundo verde bem claro
                            borderRadius: BorderRadius.circular(8.0),
                            border: Border.all(
                              color: Colors.green[200]!,
                            ), // Borda sutil
                          ),
                          child: Text(
                            "Família: $family",
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              color: Colors.green[800],
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ),
                      SizedBox(height: 24), // Espaço maior antes da descrição
                      // Verifica se a lista existe e não está vazia
                      if (alsoPresentIn.isNotEmpty)
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.center,
                          children: [
                            Text(
                              "Também presente nos biomas:",
                              style: Theme.of(context).textTheme.titleMedium
                                  ?.copyWith(fontWeight: FontWeight.bold),
                            ),
                            SizedBox(height: 8),
                            Wrap(
                              // Usa Wrap para que os nomes quebrem a linha se necessário
                              spacing:
                                  8.0, // Espaço horizontal entre os "chips"
                              runSpacing:
                                  4.0, // Espaço vertical entre as linhas
                              children: alsoPresentIn.map<Widget>((nomeBioma) {
                                // Cria um "Chip" (um card pequeno) para cada nome de bioma
                                return Chip(
                                  label: Text(nomeBioma),
                                  backgroundColor: Theme.of(context)
                                      .colorScheme
                                      .secondaryContainer
                                      .withOpacity(
                                        0.6,
                                      ), // Cor de fundo suave do tema
                                  labelStyle: TextStyle(
                                    color: Theme.of(
                                      context,
                                    ).colorScheme.onSecondaryContainer,
                                  ), // Cor do texto
                                  padding: EdgeInsets.symmetric(
                                    horizontal: 8.0,
                                    vertical: 4.0,
                                  ),
                                );
                              }).toList(),
                            ),
                            SizedBox(height: 24), // Espaço depois da seção
                          ],
                        ),
                      // Descrição
                      StyledContentBox(
                        child: Text(
                          description ?? 'Descrição não disponível.',
                          textAlign: TextAlign
                              .justify, // Justifica o texto da descrição
                          style: Theme.of(context).textTheme.bodyLarge,
                        ),
                      ),
                      SizedBox(height: 20), // Espaço no final
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
