// lib/screens/quiz_screen.dart
import 'package:flutter/material.dart';

import '../models/quiz_question.dart';
import '../services/api_service.dart';
import 'quiz_score_screen.dart';
import '../navigation/fade_page_route.dart';

class QuizScreen extends StatefulWidget {
  final int biomaId;
  final String biomaNome;

  QuizScreen({required this.biomaId, required this.biomaNome});

  @override
  _QuizScreenState createState() => _QuizScreenState();
}

class _QuizScreenState extends State<QuizScreen> {
  final ApiService apiService = ApiService();
  late Future<List<QuizQuestion>> _quizFuture;

  List<QuizQuestion> _questions = [];
  int _currentQuestionIndex = 0;
  int _score = 0;
  bool _answered = false;
  int? _selectedOptionId;

  @override
  void initState() {
    super.initState();
    _quizFuture = apiService.fetchQuizQuestions(widget.biomaId);
  }

  void _handleAnswer(int selectedOptionId) {
    if (_answered) return;

    final bool isCorrect =
        selectedOptionId == _questions[_currentQuestionIndex].idRespostaCorreta;

    setState(() {
      _answered = true;
      _selectedOptionId = selectedOptionId;
      if (isCorrect) {
        _score++;
      }
    });

    Future.delayed(Duration(seconds: 2), () {
      _nextQuestion();
    });
  }

  void _nextQuestion() {
    if (_currentQuestionIndex < _questions.length - 1) {
      setState(() {
        _currentQuestionIndex++;
        _answered = false;
        _selectedOptionId = null;
      });
    } else {
      Navigator.pushReplacement(
        context,
        FadePageRoute(
          child: QuizScoreScreen(
            score: _score,
            totalQuestions: _questions.length,
            biomaId: widget.biomaId,
            biomaNome: widget.biomaNome,
          ),
        ),
      );
    }
  }

  Color _getOptionColor(int optionId) {
    if (!_answered) {
      return Colors.grey[200]!;
    }
    if (optionId == _questions[_currentQuestionIndex].idRespostaCorreta) {
      return Colors.green;
    } else if (optionId == _selectedOptionId) {
      return Colors.red;
    } else {
      return Colors.grey[200]!;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Quiz: ${widget.biomaNome}'),
        bottom: PreferredSize(
          preferredSize: Size.fromHeight(4.0),
          child: LinearProgressIndicator(
            value: _questions.isEmpty
                ? 0.0
                : (_currentQuestionIndex + 1) / _questions.length,
            backgroundColor: Colors.grey[300],
          ),
        ),
      ),
      body: FutureBuilder<List<QuizQuestion>>(
        future: _quizFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            print(snapshot.data);
            return Center(
              child: Text('Erro ao carregar o quiz: ${snapshot.error}'),
            );
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(child: Text('Nenhuma pergunta encontrada.'));
          } else {
            // Salva as perguntas no estado local
            _questions = snapshot.data!;
            final QuizQuestion currentQuestion =
                _questions[_currentQuestionIndex];

            return SingleChildScrollView(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  // Pergunta (ex: "Pergunta 1 de 10")
                  Text(
                    'Pergunta ${_currentQuestionIndex + 1} de ${_questions.length}',
                    textAlign: TextAlign.center,
                    style: Theme.of(
                      context,
                    ).textTheme.titleMedium?.copyWith(color: Colors.grey),
                  ),
                  SizedBox(height: 16),

                  // Texto da Pergunta
                  Text(
                    currentQuestion.perguntaTexto,
                    textAlign: TextAlign.center,
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  SizedBox(height: 24),

                  // Imagem (se houver)
                  if (currentQuestion.imagemUrl != null)
                    Container(
                      height: 250,
                      clipBehavior: Clip.antiAlias,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12.0),
                      ),
                      child: Image.network(
                        currentQuestion.imagemUrl!,
                        fit: BoxFit.cover,
                        errorBuilder: (c, e, s) =>
                            Center(child: Icon(Icons.broken_image, size: 60)),
                      ),
                    ),
                  SizedBox(height: 24),

                  // Botões de Opção
                  ...currentQuestion.opcoes.map((option) {
                    return Padding(
                      padding: const EdgeInsets.symmetric(vertical: 4.0),
                      child: ElevatedButton(
                        onPressed: () => _handleAnswer(option.id),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: _getOptionColor(option.id),
                          foregroundColor: _answered
                              ? Colors.white
                              : Colors.black, // Cor do texto
                          padding: EdgeInsets.symmetric(vertical: 16),
                          textStyle: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        child: Text(option.text),
                      ),
                    );
                  }).toList(),
                ],
              ),
            );
          }
        },
      ),
    );
  }
}
