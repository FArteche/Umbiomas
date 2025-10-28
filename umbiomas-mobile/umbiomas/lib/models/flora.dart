class Flora {
  final int id;
  final String nome;
  final String? nomeCientifico;
  final String? familia;
  final String? descricao;
  final String? imagemUrl;

  Flora({
    required this.id,
    required this.nome,
    this.nomeCientifico,
    this.familia,
    this.descricao,
    this.imagemUrl,
  });

  factory Flora.fromJson(Map<String, dynamic> json){
    return Flora(
      id: json['id'],
      nome: json['nome'],
      nomeCientifico: json['nome_cientifico'],
      familia: json['familia'],
      descricao: json['descricao'],
      imagemUrl: json['imagem_url']
    );
  }
}
