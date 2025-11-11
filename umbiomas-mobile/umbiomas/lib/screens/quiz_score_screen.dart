import 'package:flutter/material.dart';
import 'package:umbiomas/models/info_postador.dart';
import 'package:umbiomas/screens/quiz_ranking_screen.dart';
import 'package:umbiomas/services/api_service.dart';
import '../navigation/fade_page_route.dart';

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

  InputDecoration _inputDecoration(String label) {
    return InputDecoration(
      labelText: label,
      filled: true,
      fillColor: Colors.purple[50]!.withOpacity(0.6),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide.none,
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide(color: Colors.purple[700]!, width: 2),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final Color quizPrimaryColor = Colors.purple[700]!;
    final Color quizGradientStart = Colors.purple[300]!.withOpacity(0.5);
    final Color quizGradientEnd = Colors.white;

    return Scaffold(
      appBar: AppBar(
        title: Text('Quiz Finalizado!'),
        backgroundColor: quizPrimaryColor, // Cor tema
        automaticallyImplyLeading: false,
      ),
      body: Container(
        // Aplicando o gradiente de fundo
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
          padding: const EdgeInsets.all(24.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
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
                  color: quizPrimaryColor, // Cor tema
                  fontWeight: FontWeight.bold,
                ),
              ),
              SizedBox(height: 40),
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
                      decoration: _inputDecoration(
                        'Seu Nome*',
                      ), // Estilo aplicado
                      validator: (value) => value == null || value.isEmpty
                          ? 'Campo obrigatório'
                          : null,
                    ),
                    SizedBox(height: 12),
                    TextFormField(
                      controller: _emailController,
                      decoration: _inputDecoration(
                        'Seu Email*',
                      ), // Estilo aplicado
                      keyboardType: TextInputType.emailAddress,
                      validator: (value) {
                        if (value == null || value.isEmpty)
                          return 'Campo obrigatório';
                        final emailRegex = RegExp(
                          r"^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z]+",
                        );
                        if (!emailRegex.hasMatch(value))
                          return 'Email inválido';
                        return null;
                      },
                    ),
                  ],
                ),
              ),
              SizedBox(height: 24),
              ElevatedButton(
                onPressed: _isLoading ? null : _submitAndShowRanking,
                style: ElevatedButton.styleFrom(
                  backgroundColor: quizPrimaryColor, // Cor tema
                  foregroundColor: Colors.white,
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

              TextButton(
                onPressed: () {
                  Navigator.of(context).popUntil((route) => route.isFirst);
                },
                child: Text(
                  'Voltar ao Menu Principal',
                  style: TextStyle(color: quizPrimaryColor),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
