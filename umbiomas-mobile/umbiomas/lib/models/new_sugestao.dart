class NewSugestao {
  final String texto;

  NewSugestao({
    required this.texto,
  });

  Map<String, dynamic> toJson() {
    return {
      'texto': texto,
    };
  }
}