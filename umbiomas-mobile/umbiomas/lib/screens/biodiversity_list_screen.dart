import 'package:flutter/material.dart';
import 'package:umbiomas/models/area_preservacao.dart';
import 'package:umbiomas/models/caracteristica_se.dart';
import 'package:umbiomas/models/clima.dart';
import 'package:umbiomas/models/fauna.dart';
import 'package:umbiomas/models/flora.dart';
import 'package:umbiomas/models/hidrografia.dart';
import 'package:umbiomas/models/relevo.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/area_preservacao_detail_screen.dart';
import 'package:umbiomas/screens/caracteristica_se_detail_screen.dart';
import 'package:umbiomas/screens/clima_detail_screen.dart';
import 'package:umbiomas/screens/fauna_flora_detail_screen.dart';
import 'package:umbiomas/screens/hidro_relevo_detail_screen.dart';
import '../services/api_service.dart';

typedef FetchFunction<T> = Future<List<T>> Function({String? search});

class BiodiversityListScreen<T> extends StatefulWidget {
  final String title;
  final FetchFunction<T> fetchFunction;
  final int biomaId;

  BiodiversityListScreen({
    required this.title,
    required this.fetchFunction,
    required this.biomaId,
  });

  @override
  _BiodiversityListScreenState<T> createState() =>
      _BiodiversityListScreenState<T>();
}

class _BiodiversityListScreenState<T> extends State<BiodiversityListScreen<T>> {
  final ApiService apiService = ApiService();
  final TextEditingController _searchController = TextEditingController();
  Future<List<T>>? _itemsFuture;
  String? _currentSearchTerm;

  @override
  void initState() {
    super.initState();
    _fetchItems();
  }

  void _fetchItems({String? searchTerm}) {
    setState(() {
      _currentSearchTerm = searchTerm;
      _itemsFuture = widget.fetchFunction(search: searchTerm);
    });
  }

  void _onSearchSubmitted(String searchTerm) {
    _fetchItems(searchTerm: searchTerm);
  }

  void _clearSearch() {
    _searchController.clear();
    _fetchItems();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(widget.title)),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightGreen[100]!, Colors.lightGreen[50]!],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: Column(
          children: [
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: TextField(
                controller: _searchController,
                decoration: InputDecoration(
                  fillColor: Colors.white,
                  filled: true,
                  labelText: 'Buscar...',
                  hintText: 'Digite o nome...',
                  prefixIcon: Icon(Icons.search),
                  suffixIcon:
                      _currentSearchTerm != null &&
                          _currentSearchTerm!.isNotEmpty
                      ? IconButton(
                          icon: Icon(Icons.clear),
                          onPressed: _clearSearch,
                        )
                      : null,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8.0),
                  ),
                ),
                onSubmitted: _onSearchSubmitted,
              ),
            ),
            Expanded(
              child: FutureBuilder<List<T>>(
                future: _itemsFuture,
                builder: (context, snapshot) {
                  if (_itemsFuture == null) {
                    return Center(child: Text("Iniciando busca..."));
                  }
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return Center(child: CircularProgressIndicator());
                  } else if (snapshot.hasError) {
                    return Center(child: Text('Erro: ${snapshot.error}'));
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return Center(child: Text('Nenhum item encontrado.'));
                  } else {
                    List<T> items = snapshot.data!;
                    return ListView.builder(
                      itemCount: items.length,
                      itemBuilder: (content, index) {
                        final item = items[index];
                        String itemName = 'Nome Indisponível';
                        String? itemImageUrl;
                        String? itemSubtitle;
                        try {
                          itemName = (item as dynamic).nome;
                        } catch (e) {}
                        try {
                          itemImageUrl = (item as dynamic).imagemUrl;
                        } catch (e) {}
                        try {
                          itemSubtitle =
                              (item as dynamic).nomeCientifico ??
                              (item as dynamic).familia ??
                              (item as dynamic).tipo ??
                              "";
                        } catch (e) {}
                        return Card(
                          clipBehavior: Clip.antiAlias,
                          child: InkWell(
                            onTap: () {
                              int itemId = 0; // Precisa pegar o ID do item
                              try {
                                itemId = (item as dynamic).id;
                              } catch (e) {
                                print("Erro ao pegar ID");
                                return;
                              }

                              // Decide para qual tela navegar baseado no tipo T da lista
                              Widget detailScreen;
                              if (T == Fauna) {
                                detailScreen = FaunaFloraDetailScreen(
                                  itemId: itemId,
                                  itemType: 'fauna',
                                );
                              } else if (T == Flora) {
                                detailScreen = FaunaFloraDetailScreen(
                                  itemId: itemId,
                                  itemType: 'flora',
                                );
                              } else if (T == Clima) {
                                detailScreen = ClimaDetailScreen(
                                  itemId: itemId,
                                  itemType: 'clima',
                                );
                              } else if (T == Hidrografia) {
                                detailScreen = HidroRelevoDetailScreen(
                                  itemId: itemId,
                                  itemType: 'hidrografia',
                                );
                              } else if (T == Relevo) {
                                detailScreen = HidroRelevoDetailScreen(
                                  itemId: itemId,
                                  itemType: 'relevo',
                                );
                              } else if (T == CaracteristicaSe) {
                                detailScreen = CaracteristicaSeDetailScreen(
                                  itemId: itemId,
                                );
                              } else if (T == AreaPreservacao) {
                                detailScreen = AreaPreservacaoDetailScreen(
                                  itemId: itemId,
                                );
                              } else {
                                // Tela de fallback ou erro
                                detailScreen = Scaffold(
                                  appBar: AppBar(),
                                  body: Center(
                                    child: Text(
                                      "Tela de detalhes não implementada para este tipo.",
                                    ),
                                  ),
                                );
                              }

                              Navigator.push(
                                context,
                                FadePageRoute(child: detailScreen),
                              );
                            },
                            child: Row(
                              children: [
                                Container(
                                  width: 80,
                                  height: 80,
                                  child: itemImageUrl != null
                                      ? Image.network(
                                          itemImageUrl,
                                          fit: BoxFit.cover,
                                          errorBuilder: (c, e, s) =>
                                              Icon(Icons.broken_image),
                                        )
                                      : Icon(
                                          Icons.image_not_supported,
                                          size: 40,
                                          color: Colors.grey,
                                        ),
                                ),
                                // Textos
                                Expanded(
                                  child: Padding(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 12.0,
                                    ),
                                    child: Column(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      children: [
                                        Text(
                                          itemName,
                                          style: TextStyle(
                                            fontWeight: FontWeight.bold,
                                            fontSize: 16,
                                          ),
                                        ),
                                        if (itemSubtitle != null)
                                          Text(
                                            itemSubtitle,
                                            style: TextStyle(
                                              fontSize: 12,
                                              color: Colors.grey[600],
                                            ),
                                            maxLines: 1,
                                            overflow: TextOverflow.ellipsis,
                                          ),
                                      ],
                                    ),
                                  ),
                                ),
                                Padding(
                                  padding: const EdgeInsets.only(right: 8.0),
                                  child: Icon(
                                    Icons.chevron_right,
                                    color: Colors.grey,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        );
                      },
                    );
                  }
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
