class InfoPostador {
  final String nome;
  final String email;
  final String? telefone;
  final String instituicao;
  final String? ocupacao;

  InfoPostador({
    required this.nome,
    required this.email,
    this.telefone,
    required this.instituicao,
    this.ocupacao,
  });

  Map<String, dynamic> toJson() {
    return {
      'nome': nome,
      'email': email,
      'telefone': telefone,
      'instituicao': instituicao,
      'ocupacao': ocupacao,
    };
  }
}
