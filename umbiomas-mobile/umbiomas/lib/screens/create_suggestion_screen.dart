import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/info_postador.dart';
import '../models/new_sugestao.dart';

class CreateSuggestionScreen extends StatefulWidget {
  @override
  _CreateSuggestionScreenState createState() => _CreateSuggestionScreenState();
}

class _CreateSuggestionScreenState extends State<CreateSuggestionScreen> {
  final _formKey = GlobalKey<FormState>();
  final ApiService apiService = ApiService();
  bool _isLoading = false;

  final _nomeController = TextEditingController();
  final _emailController = TextEditingController();
  final _telefoneController = TextEditingController();
  final _instituicaoController = TextEditingController();
  final _ocupacaoController = TextEditingController();
  final _textoController = TextEditingController();

  @override
  void dispose() {
    _nomeController.dispose();
    _emailController.dispose();
    _textoController.dispose();
    _telefoneController.dispose();
    _instituicaoController.dispose();
    _ocupacaoController.dispose();
    super.dispose();
  }

  Future<void> _submitForm() async {
    if (!_formKey.currentState!.validate()) return;
    setState(() => _isLoading = true);

    final postador = InfoPostador(
      nome: _nomeController.text,
      email: _emailController.text,
      instituicao: _instituicaoController.text,
      telefone: _telefoneController.text,
      ocupacao: _ocupacaoController.text,
    );
    final newSugestao = NewSugestao(texto: _textoController.text);

    try {
      await apiService.createSugestao(
        postador: postador,
        sugestao: newSugestao,
      );
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Sugestão enviada com sucesso!'),
          backgroundColor: Colors.green,
        ),
      );
      Navigator.of(context).pop();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erro ao enviar sugestão: $e'),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }

  InputDecoration _inputDecoration(String label) {
    return InputDecoration(
      labelText: label,
      alignLabelWithHint: true,
      filled: true,
      fillColor: Colors.orange[400]!.withOpacity(0.6), // Cor tema laranja
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide.none, 
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12.0),
        borderSide: BorderSide(
          color: Colors.orange[800]!,
          width: 2,
        ), // Borda laranja ao focar
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Define as cores do tema da seção
    final Color suggestionPrimaryColor =
        Colors.orange[700]!; // Um laranja mais forte para AppBar
    final Color suggestionGradientStart = Colors.orange[100]!;
    final Color suggestionGradientEnd = Colors.white;

    return Scaffold(
      appBar: AppBar(
        title: Text('Enviar Sugestão'),
        backgroundColor: suggestionPrimaryColor, // Cor tema laranja
      ),
      // Adiciona o container com o gradiente de fundo
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [
              suggestionGradientStart,
              suggestionGradientEnd,
            ], // Gradiente laranja
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.stretch, // Estica os filhos
              children: [
                Text(
                  'Suas Informações',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _nomeController,
                  decoration: _inputDecoration('Seu Nome*'), // Estilo aplicado
                  validator: (value) => value == null || value.isEmpty
                      ? 'Campo obrigatório'
                      : null,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _emailController,
                  decoration: _inputDecoration('Seu Email*'), // Estilo aplicado
                  keyboardType: TextInputType.emailAddress,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Campo obrigatório';
                    }
                    final emailRegex = RegExp(
                      r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~-]+@[a-zA-Z0-9]+\.[a-zA-Z]+",
                    );
                    if (!emailRegex.hasMatch(value)) {
                      return 'Por favor, insira um email válido';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _telefoneController,
                  decoration: _inputDecoration(
                    'Seu Telefone',
                  ), // Estilo aplicado (opcional)
                  // Validator removido para ser opcional
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _ocupacaoController,
                  decoration: _inputDecoration(
                    'Sua Ocupação',
                  ), // Estilo aplicado (opcional)
                  // Validator removido para ser opcional
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _instituicaoController,
                  decoration: _inputDecoration(
                    'Instituição que pertence',
                  ), // Estilo aplicado (opcional)
                  // Validator removido para ser opcional
                ),
                SizedBox(height: 24),
                Text(
                  'Sua Sugestão',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                TextFormField(
                  controller: _textoController,
                  decoration: _inputDecoration(
                    'Texto da Sugestão*',
                  ), // Estilo aplicado
                  maxLines: 8,
                  validator: (value) => value == null || value.isEmpty
                      ? 'Campo obrigatório'
                      : null,
                ),
                SizedBox(height: 24),
                ElevatedButton(
                  onPressed: _isLoading ? null : _submitForm,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: suggestionPrimaryColor, // Cor tema laranja
                    foregroundColor: Colors.white, // Texto branco
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
                      : Text('Enviar Sugestão', style: TextStyle(fontSize: 16)),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
