// lib/screens/quiz_score_screen.dart
import 'package:flutter/material.dart';
import 'package:umbiomas/models/info_postador.dart';
import 'package:umbiomas/screens/quiz_ranking_screen.dart'; // Vamos criar esta
import 'package:umbiomas/services/api_service.dart';
import '../navigation/fade_page_route.dart'; // Importe a rota de animação

class QuizScoreScreen extends StatefulWidget {
  final int score;
  final int totalQuestions;
  final int biomaId;
  final String biomaNome;

  const QuizScoreScreen({
    Key? key,
    required this.score,
    required this.totalQuestions,
    required this.biomaId,
    required this.biomaNome,
  }) : super(key: key);

  @override
  _QuizScoreScreenState createState() => _QuizScoreScreenState();
}

class _QuizScoreScreenState extends State<QuizScoreScreen> {
  final _formKey = GlobalKey<FormState>();
  final ApiService apiService = ApiService();
  bool _isLoading = false;

  final _nomeController = TextEditingController();
  final _emailController = TextEditingController();

  @override
  void dispose() {
    _nomeController.dispose();
    _emailController.dispose();
    super.dispose();
  }

  Future<void> _submitAndShowRanking() async {
    if (!_formKey.currentState!.validate()) {
      return; 
    }

    setState(() => _isLoading = true);

    try {
      final postador = InfoPostador(
        nome: _nomeController.text,
        email: _emailController.text,
        instituicao: '',
      );

      // 1. Salva a pontuação na API
      await apiService.submitQuizScore(
        biomaId: widget.biomaId,
        score: widget.score,
        postador: postador,
      );

      // 2. Se salvou, navega para a tela de ranking
      Navigator.pushReplacement(
        context,
        FadePageRoute(
          child: QuizRankingScreen(
            biomaId: widget.biomaId,
            biomaNome: widget.biomaNome,
          ),
        ),
      );
    } catch (e) {
      // Se deu erro, mostra mensagem
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erro ao salvar pontuação: $e'),
          backgroundColor: Colors.red,
        ),
      );
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Quiz Finalizado!'),
        automaticallyImplyLeading: false, // Remove a seta de "voltar"
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            // Exibição da Pontuação
            Text(
              'Sua Pontuação:',
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            SizedBox(height: 16),
            Text(
              '${widget.score} / ${widget.totalQuestions}',
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.displayMedium?.copyWith(
                color: Theme.of(context).colorScheme.primary,
                fontWeight: FontWeight.bold,
              ),
            ),
            SizedBox(height: 40),

            // Formulário para o Ranking
            Text(
              'Entre para o Ranking Semanal!',
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.titleLarge,
            ),
            SizedBox(height: 16),
            Form(
              key: _formKey,
              child: Column(
                children: [
                  TextFormField(
                    controller: _nomeController,
                    decoration: InputDecoration(
                      labelText: 'Seu Nome*',
                      filled: true,
                      fillColor: Colors.grey[100],
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8.0),
                        borderSide: BorderSide.none,
                      ),
                    ),
                    validator: (value) => value == null || value.isEmpty
                        ? 'Campo obrigatório'
                        : null,
                  ),
                  SizedBox(height: 12),
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: 'Seu Email*',
                      filled: true,
                      fillColor: Colors.grey[100],
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8.0),
                        borderSide: BorderSide.none,
                      ),
                    ),
                    keyboardType: TextInputType.emailAddress,
                    validator: (value) {
                      if (value == null || value.isEmpty)
                        return 'Campo obrigatório';
                      final emailRegex = RegExp(
                        r"^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z]+",
                      );
                      if (!emailRegex.hasMatch(value)) return 'Email inválido';
                      return null;
                    },
                  ),
                ],
              ),
            ),
            SizedBox(height: 24),

            // Botão de Salvar
            ElevatedButton(
              onPressed: _isLoading ? null : _submitAndShowRanking,
              style: ElevatedButton.styleFrom(
                padding: EdgeInsets.symmetric(vertical: 16),
              ),
              child: _isLoading
                  ? SizedBox(
                      width: 20,
                      height: 20,
                      child: CircularProgressIndicator(
                        strokeWidth: 2,
                        color: Colors.white,
                      ),
                    )
                  : Text(
                      'Salvar e Ver Ranking',
                      style: TextStyle(fontSize: 16),
                    ),
            ),

            SizedBox(height: 12),

            // Botão de Voltar ao Menu
            TextButton(
              onPressed: () {
                // Pop 3 vezes para voltar ao Menu Principal
                // (Pop 1: QuizScoreScreen, Pop 2: QuizScreen, Pop 3: QuizSelectionScreen)
                int count = 0;
                Navigator.of(context).popUntil((_) => count++ >= 3);
              },
              child: Text('Voltar ao Menu Principal'),
            ),
          ],
        ),
      ),
    );
  }
}
