class QuizOption {
  final int id;
  final String text;

  QuizOption({required this.id, required this.text});

  factory QuizOption.fromJson(Map<String, dynamic> json) {
    return QuizOption(
      id: json['id'] as int? ?? 0,
      text: json['text'] as String? ?? 'Opção Inválida',
    );
  }
}
