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
import 'package:umbiomas/theme/app_theme.dart';
import '../services/api_service.dart';

typedef FetchFunction<T> = Future<List<T>> Function({String? search});

class BiodiversityListScreen<T> extends StatefulWidget {
  final String title;
  final FetchFunction<T> fetchFunction;
  final int biomaId;
  final Type itemType;

  BiodiversityListScreen({
    required this.title,
    required this.fetchFunction,
    required this.biomaId,
    required this.itemType, 
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
      appBar: AppBar(title: Text(widget.title)), // Cor do tema
      body: Container(
        decoration: BoxDecoration(gradient: AppTheme.backgroundGradient), // Fundo gradiente
        child: Column(
          children: [
            // Barra de Busca Estilizada
            Padding(
              padding: const EdgeInsets.all(12.0),
              child: TextField(
                controller: _searchController,
                decoration: InputDecoration(
                  hintText: 'Buscar...',
                  hintStyle: TextStyle(color: Colors.grey[600]),
                  prefixIcon: Icon(Icons.search, color: Colors.grey[700]),
                  suffixIcon:
                      _currentSearchTerm != null &&
                          _currentSearchTerm!.isNotEmpty
                      ? IconButton(
                          icon: Icon(Icons.clear, color: Colors.grey[700]),
                          onPressed: _clearSearch,
                        )
                      : null,
                  filled: true,
                  fillColor: Colors.white,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12.0),
                    borderSide: BorderSide.none, // Sem borda
                  ),
                  focusedBorder: OutlineInputBorder( // Borda quando focado
                    borderRadius: BorderRadius.circular(12.0),
                    borderSide: BorderSide(color: AppTheme.primaryColor, width: 2),
                  ),
                ),
                onSubmitted: _onSearchSubmitted,
              ),
            ),
            // Lista de Itens
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
                      padding: EdgeInsets.symmetric(horizontal: 10.0, vertical: 4.0),
                      itemCount: items.length,
                      itemBuilder: (content, index) {
                        final item = items[index];
                        // Lógica para extrair dados (igual à sua)
                        String itemName = 'Nome Indisponível';
                        String? itemImageUrl;
                        String? itemSubtitle;
                        try { itemName = (item as dynamic).nome; } catch (e) {}
                        try { itemImageUrl = (item as dynamic).imagemUrl; } catch (e) {}
                        try {
                          itemSubtitle =
                              (item as dynamic).nomeCientifico ??
                              (item as dynamic).familia ??
                              (item as dynamic).tipo ??
                              "";
                        } catch (e) {}
                        
                        return Card(
                          margin: EdgeInsets.symmetric(vertical: 6.0),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
                          clipBehavior: Clip.antiAlias,
                          elevation: 2,
                          child: InkWell(
                            onTap: () {
                              int itemId = 0;
                              try { itemId = (item as dynamic).id; } catch (e) { print("Erro ao pegar ID"); return; }

                              Widget detailScreen;
                              // Lógica de navegação baseada no tipo
                              if (widget.itemType == Fauna) {
                                detailScreen = FaunaFloraDetailScreen(itemId: itemId, itemType: 'fauna');
                              } else if (widget.itemType == Flora) {
                                detailScreen = FaunaFloraDetailScreen(itemId: itemId, itemType: 'flora');
                              } else if (widget.itemType == Clima) {
                                detailScreen = ClimaDetailScreen(itemId: itemId, itemType: 'clima');
                              } else if (widget.itemType == Hidrografia) {
                                detailScreen = HidroRelevoDetailScreen(itemId: itemId, itemType: 'hidrografia');
                              } else if (widget.itemType == Relevo) {
                                detailScreen = HidroRelevoDetailScreen(itemId: itemId, itemType: 'relevo');
                              } else if (widget.itemType == CaracteristicaSe) {
                                detailScreen = CaracteristicaSeDetailScreen(itemId: itemId);
                              } else if (widget.itemType == AreaPreservacao) {
                                detailScreen = AreaPreservacaoDetailScreen(itemId: itemId);
                              } else {
                                detailScreen = Scaffold(appBar: AppBar(), body: Center(child: Text("Tela não implementada.")));
                              }

                              Navigator.push(context, FadePageRoute(child: detailScreen));
                            },
                            // Layout do ListTile para consistência
                            child: ListTile(
                              contentPadding: EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
                              leading: ClipRRect(
                                borderRadius: BorderRadius.circular(8.0),
                                child: Container(
                                  width: 60,
                                  height: 60,
                                  color: Colors.grey[200],
                                  child: itemImageUrl != null
                                      ? Image.network(
                                          itemImageUrl,
                                          fit: BoxFit.cover,
                                          errorBuilder: (c, e, s) => Icon(Icons.broken_image, color: Colors.grey),
                                        )
                                      : Icon(Icons.image_not_supported, color: Colors.grey),
                                ),
                              ),
                              title: Text(itemName, style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                              subtitle: itemSubtitle != null && itemSubtitle.isNotEmpty
                                ? Text(itemSubtitle, maxLines: 1, overflow: TextOverflow.ellipsis)
                                : null,
                              trailing: Icon(Icons.chevron_right, color: Colors.grey),
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