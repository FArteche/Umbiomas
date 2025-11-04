// lib/screens/quiz_selection_screen.dart
import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/bioma.dart';
import '../widgets/ranking_preview.dart'; 
import 'quiz_screen.dart'; 

class QuizSelectionScreen extends StatefulWidget {
  @override
  _QuizSelectionScreenState createState() => _QuizSelectionScreenState();
}

class _QuizSelectionScreenState extends State<QuizSelectionScreen> {
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
        title: Text('Escolha um Quiz'),
      ),
      body: FutureBuilder<List<Bioma>>(
        future: _biomasFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Erro ao carregar biomas: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(child: Text('Nenhum bioma encontrado.'));
          } else {
            List<Bioma> biomas = snapshot.data!;
            
            return ListView.builder(
              itemCount: biomas.length,
              itemBuilder: (context, index) {
                final bioma = biomas[index];
                
                return Column(
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  children: [
                    Card(
                      margin: EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                      clipBehavior: Clip.antiAlias,
                      elevation: 4,
                      child: InkWell(
                        onTap: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => QuizScreen(
                                biomaId: bioma.id,
                                biomaNome: bioma.nome,
                              ),
                            ),
                          );
                        },
                        child: Container(
                          height: 150,
                          decoration: BoxDecoration(
                            image: DecorationImage(
                              image: bioma.imagemUrl != null
                                  ? NetworkImage(bioma.imagemUrl!)
                                  : AssetImage('assets/images/placeholder.png') as ImageProvider,
                              fit: BoxFit.cover,
                              colorFilter: ColorFilter.mode(
                                Colors.black.withOpacity(0.4), 
                                BlendMode.darken
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
                                    Shadow(blurRadius: 10.0, color: Colors.black.withOpacity(0.5), offset: Offset(2.0, 2.0)),
                                  ],
                                ),
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                    
                    RankingPreview(biomaId: bioma.id),

                    Divider(height: 30, thickness: 1, indent: 20, endIndent: 20),
                  ],
                );
              },
            );
          }
        },
      ),
    );
  }
}