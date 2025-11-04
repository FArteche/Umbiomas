class Flora {
  final int id;
  final String nome;
  final String? nomeCientifico;
  final String? familia;
  final String? descricao;
  final String? imagemUrl;
  final List<String>? tambemPresenteEm;

  Flora({
    required this.id,
    required this.nome,
    this.nomeCientifico,
    this.familia,
    this.descricao,
    this.imagemUrl,
    this.tambemPresenteEm,
  });

  factory Flora.fromJson(Map<String, dynamic> json) {
    List<String>? outrosBiomas;
    if (json['tambem_presente_em'] != null &&
        json['tambem_presente_em'] is List) {
      outrosBiomas = List<String>.from(json['tambem_presente_em']);
    }

    return Flora(
      id: json['id'],
      nome: json['nome'],
      nomeCientifico: json['nome_cientifico'],
      familia: json['familia'],
      descricao: json['descricao'],
      imagemUrl: json['imagem_url'],
      tambemPresenteEm: outrosBiomas
    );
  }
}
