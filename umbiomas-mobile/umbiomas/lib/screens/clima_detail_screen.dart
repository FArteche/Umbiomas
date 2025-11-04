import 'package:flutter/material.dart';
import 'package:umbiomas/widgets/styled_content_box.dart';
import '../services/api_service.dart';

class ClimaDetailScreen extends StatefulWidget {
  final int itemId;
  final String itemType;

  ClimaDetailScreen({required this.itemId, required this.itemType});

  @override
  _ClimaDetailScreenState createState() => _ClimaDetailScreenState();
}

class _ClimaDetailScreenState extends State<ClimaDetailScreen> {
  final ApiService apiService = ApiService();
  late Future<dynamic> _itemDetailFuture;

  @override
  void initState() {
    super.initState();
    _itemDetailFuture = apiService.fetchClimaDetail(widget.itemId);
  }

  @override
  Widget build(BuildContext context) {
    // Usamos FutureBuilder fora do Scaffold para poder definir o título da AppBar
    return FutureBuilder<dynamic>(
      future: _itemDetailFuture,
      builder: (context, snapshot) {
        String appBarTitle = 'Detalhes do Clima';
        dynamic itemData; // Variável para guardar os dados após o carregamento

        if (snapshot.hasData) {
          itemData = snapshot.data!;
          appBarTitle =
              itemData.nome ?? appBarTitle; // Usa o nome do item se carregado
        }

        return Scaffold(
          // AppBar simples, similar à da BiodiversityListScreen
          appBar: AppBar(
            title: Text(appBarTitle),
            // O botão voltar é adicionado automaticamente pelo Flutter ao usar Navigator.push
          ),
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
                // --- CONSTRUÇÃO DO CORPO DA PÁGINA ---
                // Acessa as propriedades (similar ao código anterior)
                String title = itemData.nome ?? 'Nome Indisponível';
                String? imageUrl = itemData.imagemUrl;
                String? description = itemData.descricao;
                List<String> alsoPresentIn = itemData.tambemPresenteEm;

                return SingleChildScrollView(
                  padding: const EdgeInsets.all(16.0), // Espaçamento geral
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment
                        .center, // Centraliza os itens horizontalmente
                    children: [
                      // Nome Principal
                      Text(
                        title,
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.headlineMedium
                            ?.copyWith(fontWeight: FontWeight.bold),
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
                      // Verifica se a lista existe e não está vazia
                      if (alsoPresentIn.isNotEmpty)
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.center,
                          children: [
                            Text(
                              "Presente nos biomas:",
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
