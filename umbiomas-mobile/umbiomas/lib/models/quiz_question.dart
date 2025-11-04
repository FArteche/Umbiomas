import 'quiz_option.dart';

class QuizQuestion {
  final String tipo;
  final String perguntaTexto;
  final String? imagemUrl;
  final List<QuizOption> opcoes;
  final int idRespostaCorreta;

  QuizQuestion({
    required this.tipo,
    required this.perguntaTexto,
    this.imagemUrl,
    required this.opcoes,
    required this.idRespostaCorreta,
  });

  factory QuizQuestion.fromJson(Map<String, dynamic> json) {
    var opcoesList = json['opcoes'] as List? ?? [];
    List<QuizOption> opcoes = opcoesList
        .map((i) => QuizOption.fromJson(i))
        .toList();

    return QuizQuestion(
      tipo: json['tipo_quiz'] as String? ?? 'texto',
      perguntaTexto:
          json['pergunta_texto'] as String? ?? 'Pergunta não encontrada',
      imagemUrl: json['imagem_url'] as String?,
      opcoes: opcoes,
      idRespostaCorreta: json['id_resposta_correta'] as int? ?? 0,
    );
  }
}
