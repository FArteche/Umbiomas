import 'package:flutter/material.dart';
import 'package:umbiomas/theme/app_theme.dart';

class StyledContentBox extends StatelessWidget {
  final Widget child;
  final EdgeInsetsGeometry? padding;

  const StyledContentBox({
    Key? key,
    required this.child,
    this.padding,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: padding ?? const EdgeInsets.all(12.0), // Padding padrão de 12
      width: double.infinity,
      decoration: BoxDecoration(
        color: AppTheme.contentBoxColor, // Cor lightGreen[100]
        border: Border.all(
          color: AppTheme.contentBoxBorderColor, // Cor green[900]
          width: 1.5,
        ),
        borderRadius: BorderRadius.circular(5.0),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.3), // Sombra mais suave
            spreadRadius: 1,
            blurRadius: 3,
            offset: Offset(0, 2),
          ),
        ],
      ),
      child: child,
    );
  }
}