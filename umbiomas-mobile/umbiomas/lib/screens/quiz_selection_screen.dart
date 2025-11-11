import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:umbiomas/screens/quiz_start_screen.dart';
import '../services/api_service.dart';
import '../models/bioma.dart';
import '../widgets/ranking_preview.dart';
import '../navigation/fade_page_route.dart';

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
    final Color quizPrimaryColor = Colors.purple[700]!;
    final Color quizGradientStart = Colors.purple[300]!.withOpacity(0.5);
    final Color quizGradientEnd = Colors.white;

    return Scaffold(
      appBar: AppBar(
        title: Text('Escolha um Quiz'),
        backgroundColor: quizPrimaryColor, // Cor tema do Quiz
      ),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [quizGradientStart, quizGradientEnd],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: FutureBuilder<List<Bioma>>(
          future: _biomasFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return Center(
                child: CircularProgressIndicator(color: quizPrimaryColor),
              );
            } else if (snapshot.hasError) {
              return Center(
                child: Text('Erro ao carregar biomas: ${snapshot.error}'),
              );
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return Center(child: Text('Nenhum bioma encontrado.'));
            } else {
              List<Bioma> biomas = snapshot.data!;

              return ListView.builder(
                padding: EdgeInsets.only(top: 10.0, bottom: 20.0),
                itemCount: biomas.length,
                itemBuilder: (context, index) {
                  final bioma = biomas[index];

                  return Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      Card(
                        margin: EdgeInsets.symmetric(
                          horizontal: 10,
                          vertical: 6,
                        ),
                        clipBehavior: Clip.antiAlias,
                        elevation: 4,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12.0),
                        ),
                        child: InkWell(
                          onTap: () {
                            Navigator.push(
                              context,
                              FadePageRoute(
                                child: QuizStartScreen(bioma: bioma),
                              ),
                            );
                          },
                          child: Container(
                            height: 150,
                            decoration: BoxDecoration(
                              image: DecorationImage(
                                image: bioma.imagemUrl != null
                                    ? NetworkImage(bioma.imagemUrl!)
                                    : AssetImage('assets/images/logo_tr.png')
                                          as ImageProvider,
                                fit: BoxFit.cover,
                                colorFilter: ColorFilter.mode(
                                  Colors.black.withOpacity(0.4),
                                  BlendMode.darken,
                                ),
                              ),
                            ),
                            child: Align(
                              alignment: Alignment.center, // Centralizado
                              child: Text(
                                bioma.nome,
                                style: GoogleFonts.lato(
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
                      ),

                      // Passa a cor primária do quiz para o widget de ranking
                      RankingPreview(
                        biomaId: bioma.id,
                        themeColor: quizPrimaryColor,
                      ),

                      Divider(
                        height: 30,
                        thickness: 1,
                        indent: 20,
                        endIndent: 20,
                      ),
                    ],
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
