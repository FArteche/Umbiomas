import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/bioma.dart';
import 'posts_list_screen.dart';

// Renomeie a classe
class PostsBiomesScreen extends StatefulWidget {
  @override
  // Renomeie o State
  _PostsBiomesScreenState createState() => _PostsBiomesScreenState();
}

// Renomeie a classe State
class _PostsBiomesScreenState extends State<PostsBiomesScreen> {
  final ApiService apiService = ApiService();
  late Future<List<Bioma>> _biomasFuture;

  @override
  void initState() {
    super.initState();
    _biomasFuture = apiService.fetchBiomas();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        // Altere o título
        title: Text('Posts por Bioma'),
        // backgroundColor: Colors.green[700], // Já definido no tema
      ),
      body: FutureBuilder<List<Bioma>>(
        future: _biomasFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(
              child: Text('Erro ao carregar Biomas: ${snapshot.error}'),
            );
          } else if (!snapshot.hasData) {
            return Center(child: Text('Biomas não encontrados.'));
          } else {
            List<Bioma> biomas = snapshot.data!;
            return ListView.builder(
              itemCount: biomas.length,
              itemBuilder: (context, index) {
                final bioma = biomas[index];
                return Card(
                  clipBehavior: Clip.antiAlias,
                  child: InkWell(
                    onTap: () {
                      // --- ALTERAÇÃO AQUI: Navega para a PostsListScreen ---
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => PostsListScreen(
                            biomaId: bioma.id,
                            biomaNome: bioma.nome,
                          ),
                        ),
                      );
                      // ---------------------------------------------------
                    },
                    child: Container(
                      height: 100,
                      decoration: BoxDecoration(
                        image: DecorationImage(
                          image: bioma.imagemUrl != null
                              ? NetworkImage(bioma.imagemUrl!)
                              : AssetImage('assets/images/placeholder.png')
                                    as ImageProvider,
                          fit: BoxFit.cover,
                          colorFilter: ColorFilter.mode(
                            Colors.black.withOpacity(0.4),
                            BlendMode.darken,
                          ),
                        ),
                      ),
                      child: Align(
                        alignment: Alignment.centerLeft,
                        child: Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 16.0),
                          child: Text(
                            bioma.nome,
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 20, 
                              fontWeight: FontWeight.bold, 
                              shadows: [
                                Shadow(
                                  blurRadius: 10.0,
                                  color: Colors.black.withOpacity(0.5),
                                  offset: Offset(2.0, 2.0),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                );
              },
            );
          }
        },
      ),
    );
  }
}
