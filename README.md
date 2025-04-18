# 🛡️ Módulo C-Protect

Este proyecto implementa un módulo de ciberseguridad desarrollado en PHP que incluye mecanismos de protección contra accesos no autorizados, bots, y ataques comunes. Además, integra un criptosistema personalizado llamado **Kiwi**, diseñado para el cifrado seguro de información.

## 📌 Funcionalidades principales

---

## 🔒 Bloqueador de IPs por Subred

Este sistema permite el acceso únicamente a direcciones IP dentro de una subred específica. Las demás IPs son bloqueadas automáticamente, reduciendo así el riesgo de accesos externos no autorizados.

> Este mecanismo es útil para entornos privados o redes internas donde se desea limitar el acceso a ciertos rangos IP.

**📸 Ejemplo visual del bloqueador de IPs:**
![image](https://github.com/user-attachments/assets/4a7d3938-6d80-46f4-bb2c-5128ace239b8)


---

## 🤖 Sistema CAPTCHA Antibots

Para evitar interacciones automatizadas, se implementó un sistema CAPTCHA ligero que requiere verificación humana antes de permitir el acceso a ciertos recursos.

> Ideal para formularios de login, registro u otras operaciones sensibles donde se desee evitar ataques de fuerza bruta automatizados.

**📸 Vista del sistema CAPTCHA:**
![image](https://github.com/user-attachments/assets/8abe380d-5c67-41f1-b9b0-dec7ecf6c9b7)


---

## 🕒 Control de Sesiones con Tiempo de Vida

El sistema controla las sesiones activas y les asigna una duración limitada. Una vez vencido el tiempo de vida, la sesión se destruye automáticamente, obligando al usuario a iniciar sesión de nuevo.

> Esto incrementa la seguridad en aplicaciones donde el abandono de sesiones abiertas puede comprometer la información del usuario.

**📸 Vista de la gestión de sesiones:**
![image](https://github.com/user-attachments/assets/2f305247-4983-4f3c-9779-7eedb0bffa3f)


---

## 🧬 Criptosistema Kiwi 🔐

Se desarrolló un criptosistema personalizado llamado **Kiwi**, el cual combina técnicas avanzadas de cifrado para proteger datos sensibles.

### 🔑 Características:

- **Tipo**: Cifrado híbrido (simétrico + clave pública/privada).
- **Estructura**: Cifrado por bloques.
- **Capas de cifrado**:
  1. **Permutación** de bits
  2. **Rotación** de bloques
  3. **Operación XOR** con clave

 
  **📸 Diagrama del criptosistema:**
  ![image](https://github.com/user-attachments/assets/af851d46-ffeb-4080-9a63-ac7fbbae19c6)



  **📸 Diagrama de la creacion de llaves:**
  ![image](https://github.com/user-attachments/assets/2e9756b9-e8cf-4a33-bed9-233508e21a95)



> Este enfoque multi-capa refuerza la resistencia contra ataques de análisis criptográfico.

### 🔐 Tamaño del espacio de claves:

- 2¹²⁸ combinaciones posibles
- Aproximadamente **3.4 × 10³⁸** (340 sextillones)

**📸 Ejemplo visual del criptosistema en acción:**
![image](https://github.com/user-attachments/assets/897476d7-85cc-43d7-9c55-d3825ab715e2)

