class Fauna {
  final int id;
  final String nome;
  final String? nomeCientifico;
  final String? familia;
  final String? descricao;
  final String? imagemUrl;

  Fauna({
    required this.id,
    required this.nome,
    this.nomeCientifico,
    this.familia,
    this.descricao,
    this.imagemUrl,
  });

  factory Fauna.fromJson(Map<String, dynamic> json){
    return Fauna(
      id: json['id'],
      nome: json['nome'],
      nomeCientifico: json['nome_cientifico'],
      familia: json['familia'],
      descricao: json['descricao'],
      imagemUrl: json['imagem_url']
    );
  }
}
