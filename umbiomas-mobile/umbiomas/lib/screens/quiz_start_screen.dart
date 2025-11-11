import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:umbiomas/models/bioma.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/quiz_screen.dart';
import 'package:umbiomas/widgets/ranking_preview.dart';
import 'package:umbiomas/widgets/styled_content_box.dart'; 

class QuizStartScreen extends StatelessWidget {
  final Bioma bioma;

  const QuizStartScreen({Key? key, required this.bioma}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    // Cores do Tema do Quiz
    final Color quizPrimaryColor = Colors.purple[700]!;
    final Color quizGradientStart = Colors.purple[300]!.withOpacity(0.5);
    final Color quizGradientEnd = Colors.white;

    return Scaffold(
      appBar: AppBar(
        title: Text('Quiz: ${bioma.nome}'),
        backgroundColor: quizPrimaryColor,
      ),
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [quizGradientStart, quizGradientEnd],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // 1. Título da Página
              Text(
                'Prepare-se para o Quiz!',
                textAlign: TextAlign.center,
                style: GoogleFonts.lato(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Colors.purple[900],
                ),
              ),
              SizedBox(height: 24),

              // 2. Card de Regras
              StyledContentBox( // Reutilizando seu widget!
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Regras do Quiz:',
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                        color: Colors.green[900],
                      ),
                    ),
                    SizedBox(height: 10),
                    _buildRuleRow(Icons.question_mark_rounded, '7 perguntas geradas aleatoriamente.'),
                    SizedBox(height: 8),
                    _buildRuleRow(Icons.image_search, 'Perguntas sobre fauna, flora, clima e mais.'),
                    SizedBox(height: 8),
                    _buildRuleRow(Icons.timer_outlined, 'Sem limite de tempo por pergunta.'),
                    SizedBox(height: 8),
                    _buildRuleRow(Icons.emoji_events_rounded, 'Sua pontuação entra para o ranking semanal!'),
                  ],
                ),
              ),
              SizedBox(height: 24),

              // 3. O Ranking Preview que já existe
              RankingPreview(biomaId: bioma.id, themeColor: quizPrimaryColor),

              SizedBox(height: 32),

              // 4. Botão de Iniciar
              ElevatedButton(
                onPressed: () {
                  // Navega para a tela de perguntas
                  Navigator.push(
                    context,
                    FadePageRoute(
                      child: QuizScreen(
                        biomaId: bioma.id,
                        biomaNome: bioma.nome,
                      ),
                    ),
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: quizPrimaryColor,
                  foregroundColor: Colors.white,
                  padding: EdgeInsets.symmetric(vertical: 16),
                  textStyle: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12.0),
                  ),
                ),
                child: Text('Começar!'),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Widget auxiliar para as linhas de regras
  Widget _buildRuleRow(IconData icon, String text) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Icon(icon, color: Colors.green[800], size: 20),
        SizedBox(width: 12),
        Expanded(
          child: Text(
            text,
            style: TextStyle(fontSize: 15, height: 1.4, color: Colors.black87),
          ),
        ),
      ],
    );
  }
}