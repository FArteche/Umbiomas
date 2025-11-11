// lib/screens/posts_biomes_screen.dart
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart'; // Importe para estilizar o texto
import 'package:umbiomas/navigation/fade_page_route.dart';
import '../services/api_service.dart';
import '../models/bioma.dart';
import 'posts_list_screen.dart';

class PostsBiomesScreen extends StatefulWidget {
  @override
  _PostsBiomesScreenState createState() => _PostsBiomesScreenState();
}

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
        title: Text('Posts por Bioma'),
        backgroundColor: Colors.blue[800], 
      ),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.lightBlue[100]!, Colors.white], 
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: FutureBuilder<List<Bioma>>(
          future: _biomasFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(child: Text('Erro ao carregar Biomas: ${snapshot.error}'));
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return Center(child: Text('Biomas não encontrados.'));
            } else {
              List<Bioma> biomas = snapshot.data!;
              return ListView.builder(
                // Adiciona padding na lista
                padding: EdgeInsets.all(10.0),
                itemCount: biomas.length,
                itemBuilder: (context, index) {
                  final bioma = biomas[index];
                  return Card(
                    // Estilização do Card
                    clipBehavior: Clip.antiAlias,
                    elevation: 3.0,
                    margin: EdgeInsets.symmetric(vertical: 6.0),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
                    child: InkWell(
                      onTap: () {
                        Navigator.push(
                          context,
                          // Usa a animação de fade
                          FadePageRoute(
                            child: PostsListScreen(
                              biomaId: bioma.id,
                              biomaNome: bioma.nome,
                            ),
                          ),
                        );
                      },
                      child: Container(
                        height: 120, // Altura ajustada
                        decoration: BoxDecoration(
                          image: DecorationImage(
                            image: bioma.imagemUrl != null
                                ? NetworkImage(bioma.imagemUrl!)
                                : AssetImage('assets/images/logo_tr.png') as ImageProvider, // Placeholder
                            fit: BoxFit.cover,
                            colorFilter: ColorFilter.mode(
                              Colors.black.withOpacity(0.45),
                              BlendMode.darken,
                            ),
                          ),
                        ),
                        child: Align(
                          alignment: Alignment.center, // Centraliza o texto
                          child: Text(
                            bioma.nome,
                            style: GoogleFonts.lato( // Usa a fonte do tema
                              color: Colors.white,
                              fontSize: 22,
                              fontWeight: FontWeight.bold,
                              shadows: [
                                Shadow(
                                  blurRadius: 10.0,
                                  color: Colors.black.withOpacity(0.7),
                                  offset: Offset(2.0, 2.0),
                                ),
                              ],
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
      ),
    );
  }
}