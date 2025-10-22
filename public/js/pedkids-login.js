// Sistema de Login PEDKIDS con Grupos y Estudiantes
class PedkidsLogin {
    constructor() {
        this.studentsData = null;
        this.currentGrade = null;
        this.currentGroup = null;
        this.currentStudent = null;
        this.selectedCharacter = null;
        this.selectedFigures = [];
        this.voiceEnabled = true;
        this.musicEnabled = true;
        
        this.init();
    }

    async init() {
        await this.loadStudentsData();
        this.setupEventListeners();
    }

    async loadStudentsData() {
        try {
            //consultar datos backend
            const response = await fetch('/estudiantes');
            this.studentsData = await response.json();
        } catch (error) {
            console.error('Error cargando datos de estudiantes:', error);
            // Datos de fallback
            this.studentsData = this.getFallbackData();
        }
    }

    getFallbackData() {
        return {
            grados: {
                "1": {
                    grupos: {
                        "A": {
                            nombre: "Grupo A",
                            estudiantes: [
                                {
                                    id: 1,
                                    nombre: "Ana",
                                    apellido: "García",
                                    personaje: "🐸",
                                    personaje_nombre: "rana",
                                    password_emoji: ["⭐", "❤️", "☀️"],
                                    activo: true
                                }
                            ]
                        }
                    }
                }
            }
        };
    }

    setupEventListeners() {
        // Botones de cerrar
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', (e) => {
                const modal = e.target.closest('.modal');
                this.closeModal(modal.id);
            });
        });

        // Cerrar modal al hacer clic fuera
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal(modal.id);
                }
            });
        });

        // Tarjetas de grado
        document.querySelectorAll('.grade-card').forEach(card => {
            card.addEventListener('click', () => this.selectGrade(card));
        });

        // Botones de login
        document.getElementById('enterBtn')?.addEventListener('click', () => this.enterWithCharacter());
        document.getElementById('normalLoginBtn')?.addEventListener('click', () => this.normalLogin());

        // Selección de figuras
        document.querySelectorAll('.figure-card').forEach(card => {
            card.addEventListener('click', () => this.selectFigure(card));
        });

        // Hover de voz
        this.setupVoiceHover();

        // Sincronizar con controles globales
        this.syncWithGlobalControls();
    }

    setupVoiceHover() {
        const textElements = document.querySelectorAll('h1, p, .grade-title, .grade-description, .grade-age, .grade-number');
        textElements.forEach(element => {
            element.addEventListener('mouseenter', () => {
                const text = element.textContent.trim();
                if (text && this.voiceEnabled) {
                    this.playVoiceText(text);
                }
            });
        });
    }

    syncWithGlobalControls() {
        // Sincronizar con controles de voz y música globales
        const musicBtn = document.getElementById('musicBtn');
        const voiceBtn = document.getElementById('voiceBtn');
        
        if (musicBtn) {
            musicBtn.addEventListener('click', () => {
                this.musicEnabled = !this.musicEnabled;
                this.playVoiceText('Música ' + (this.musicEnabled ? 'activa' : 'desactivada'));
                musicBtn.innerHTML = this.musicEnabled ? '<i class="fa fa-music"></i>' : '<i class="fa fa-volume-off"></i>';
            });
        }
        
        if (voiceBtn) {
            voiceBtn.addEventListener('click', () => {
                this.voiceEnabled = !this.voiceEnabled;
                this.playVoiceText('Voz ' + (this.voiceEnabled ? 'activa' : 'desactivada'));
                voiceBtn.innerHTML = this.voiceEnabled ? '<i class="fa fa-volume-up"></i>' : '<i class="fa fa-volume-off"></i>';
            });
        }
    }

    selectGrade(card) {
        const grade = parseInt(card.dataset.grade);
        this.currentGrade = grade;
        
        // Efecto visual
        card.style.transform = 'scale(0.95)';
        setTimeout(() => {
            card.style.transform = '';
            this.showGroupSelection();
        }, 150);
    }

    showGroupSelection() {
        const gradeData = this.studentsData.grados[this.currentGrade];
        if (!gradeData) return;

        const modal = document.getElementById('groupModal');
        const instruction = document.getElementById('groupInstruction');
        const container = document.getElementById('groupSelection');

        // Actualizar instrucción
        instruction.textContent = `Grado ${this.currentGrade} - Selecciona tu grupo`;

        // Limpiar contenedor
        container.innerHTML = '';

        // Crear tarjetas de grupos
        Object.keys(gradeData.grupos).forEach(groupKey => {
            const group = gradeData.grupos[groupKey];
            const groupCard = document.createElement('div');
            groupCard.className = 'group-card';
            groupCard.dataset.group = groupKey;
            groupCard.innerHTML = `
                <div class="group-icon">${groupKey}</div>
                <div class="group-name">${group.nombre}</div>
            `;
            
            groupCard.addEventListener('click', () => this.selectGroup(groupKey));
            container.appendChild(groupCard);
        });

        modal.classList.add('show');
        modal.style.display = 'flex';
        this.playVoiceText(`Selecciona tu grupo para el grado ${this.currentGrade}`);
    }

    selectGroup(groupKey) {
        this.currentGroup = groupKey;
        const groupData = this.studentsData.grados[this.currentGrade].grupos[groupKey];
        
        // Cerrar modal de grupos
        this.closeModal('groupModal');

        // Determinar tipo de autenticación
        if (this.currentGrade <= 2) {
            this.showCharacterSelection(groupData);
        } else {
            this.showNormalLogin(groupData);
        }
    }

    showCharacterSelection(groupData) {
        const modal = document.getElementById('characterModal');
        const title = document.getElementById('characterModalTitle');
        const desc = document.getElementById('characterModalDesc');
        const container = document.getElementById('characterSelection');
        const urlAbsoluta = window.location.origin

        // Actualizar título y descripción
        title.textContent = `🎭 ¡Selecciona tu personaje!`;
        desc.textContent = `Grupo ${this.currentGroup} - Grado ${this.currentGrade}`;

        // Limpiar contenedor
        container.innerHTML = '';

        // Crear tarjetas de estudiantes
        groupData.estudiantes.forEach(student => {
            
            console.log(student.personaje);
            const studentCard = document.createElement('div');
            studentCard.className = 'character-card';
            studentCard.dataset.studentId = student.id;
            
            // Si el personaje es un emoji, mostrarlo directamente, si no, intentar cargar imagen
  
            const personajeHTML = `<img src="${urlAbsoluta}/images/avatars/${student.personaje}" alt="${student.nombre}">`;
            studentCard.innerHTML = `
                <div class="character-icon">${personajeHTML}</div>
                <div class="character-fullname">${student.nombre.split(' ')[0]} ${student.apellido.split(' ')[0]}</div>
            `;
            
            studentCard.addEventListener('click', () => this.selectStudent(student));
            container.appendChild(studentCard);
        });

        modal.classList.add('show');
        modal.style.display = 'flex';
        this.playVoiceText(`Selecciona tu personaje del grupo ${this.currentGroup}`);
    }

    showNormalLogin(groupData) {
        const modal = document.getElementById('loginModal');
        const title = document.getElementById('loginModalTitle');
        const desc = document.getElementById('loginModalDesc');

        // Actualizar título y descripción
        title.textContent = `👤 ¡Bienvenido a PEDKIDS!`;
        desc.textContent = `Grupo ${this.currentGroup} - Grado ${this.currentGrade}`;

        modal.classList.add('show');
        modal.style.display = 'flex';
        this.playVoiceText(`Ingresa tus datos para el grupo ${this.currentGroup}`);
    }

    selectStudent(student) {
        this.currentStudent = student;
        this.selectedCharacter = student.personaje_nombre;

        // Ocultar selección de personajes
        document.getElementById('characterSelection').style.display = 'none';

        // Mostrar personaje seleccionado
        const selectedDisplay = document.getElementById('selectedCharacterDisplay');
        const urlAbsoluta = window.location.origin
        document.getElementById('selectedCharacterIcon').innerHTML = `<img src="${urlAbsoluta}/images/avatars/${student.personaje}" alt="${student.nombre}">`;
        document.getElementById('selectedCharacterName').textContent = `${student.nombre.split(' ')[0]} ${student.apellido.split(' ')[0]}`;
        document.getElementById('selectedCharacterWelcome').textContent = `¡Hola! Soy ${student.personaje_nombre}, tu compañero de aventuras`;
        selectedDisplay.style.display = 'block';

        // Mostrar sección de contraseña
        document.getElementById('passwordSection').style.display = 'block';

        // Actualizar título del modal
        document.getElementById('characterModalTitle').textContent = `🎭 ¡Perfecto! ${student.nombre.split(' ')[0]} ${student.apellido.split(' ')[0]} te acompañará`;
        document.getElementById('characterModalDesc').textContent = 'Ahora crea tu código de seguridad';

        this.playVoiceText(`¡Perfecto! Has elegido a ${student.nombre.split(' ')[0]} ${student.apellido.split(' ')[0]}. Ahora ingresa tu código de seguridad tocando 3 figuras.`);
    }

    selectFigure(card) {
        if (this.selectedFigures.length >= 3) {
            // Reiniciar selección
            this.selectedFigures = [];
            document.querySelectorAll('.figure-card').forEach(c => c.classList.remove('selected'));
            
            // Limpiar cuadritos de contraseña
            const passwordTexts = document.querySelectorAll('.password-text');
            passwordTexts.forEach(text => {
                text.textContent = '';
                text.style.backgroundColor = '#FFF';
                text.style.border = '2px solid #E0E0E0';
            });
        }

        // Agregar figura a la selección
        const figure = card.dataset.figure;
        this.selectedFigures.push(figure);
        card.classList.add('selected');

        // Actualizar display
        this.updatePasswordDisplay();

        // Verificar si se completó la contraseña
        if (this.selectedFigures.length === 3) {
            document.getElementById('enterBtn').disabled = false;
            this.playVoiceText('¡Contraseña completa! Ya puedes entrar a PEDKIDS');
        }
    }

    updatePasswordDisplay() {
        const display = document.getElementById('passwordDisplay');
        const passwordTexts = display.querySelectorAll('.password-text');
        
        const figureIcons = {
            'estrella': '⭐',
            'corazon': '❤️',
            'sol': '☀️',
            'luna': '🌙',
            'arcoiris': '🌈',
            'flor': '🌸'
        };

        // Limpiar todos los cuadritos
        passwordTexts.forEach(text => {
            text.textContent = '';
            text.style.backgroundColor = '#FFF';
            text.style.border = '2px solid #E0E0E0';
            text.style.borderRadius = '10%';
            text.style.display = 'flex';
            text.style.alignItems = 'center';
            text.style.justifyContent = 'center';
        });

        // Llenar los cuadritos con las figuras seleccionadas
        this.selectedFigures.forEach((figure, index) => {
            if (passwordTexts[index]) {
                passwordTexts[index].textContent = figureIcons[figure];
                passwordTexts[index].style.backgroundColor = '#FFE5E5';
                passwordTexts[index].style.border = '2px solid #E74C3C';
                passwordTexts[index].style.fontSize = '1.5rem';
            }
        });
    }

    enterWithCharacter() {
        if (!this.currentStudent || this.selectedFigures.length !== 3) return;

        // Verificar contraseña
        const correctPassword = this.currentStudent.password_emoji;
        const isCorrect = this.selectedFigures.every((figure, index) => {
            const figureIcons = {
                'estrella': '⭐',
                'corazon': '❤️',
                'sol': '☀️',
                'luna': '🌙',
                'arcoiris': '🌈',
                'flor': '🌸'
            };
            return figureIcons[figure] === correctPassword[index];
        });

        if (isCorrect) {
            this.playVoiceText('¡Bienvenido a PEDKIDS! Comenzando tu aventura educativa');
            
            // Redirigir con datos del estudiante
       

            setTimeout(() => {
                window.location.href = `/asignaturas/${this.currentGrade}/${this.currentStudent.id}`;
            }, 1000);
        } else {
            this.playVoiceText('Contraseña incorrecta. Inténtalo de nuevo');
            // Reiniciar selección
            this.selectedFigures = [];
            document.querySelectorAll('.figure-card').forEach(c => c.classList.remove('selected'));
            
            // Limpiar cuadritos de contraseña
            const passwordTexts = document.querySelectorAll('.password-text');
            passwordTexts.forEach(text => {
                text.textContent = '';
                text.style.backgroundColor = '#FFF';
                text.style.border = '2px solid #E0E0E0';
            });
            
            document.getElementById('enterBtn').disabled = true;
        }
    }

    normalLogin() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!username || !password) {
            this.playVoiceText('Por favor completa todos los campos');
            return;
        }

        // Buscar estudiante
        const gradeData = this.studentsData.grados[this.currentGrade];
        const groupData = gradeData.grupos[this.currentGroup];
        const student = groupData.estudiantes.find(s => s.usuario === username && s.activo);

        if (student && student.password === password) {
            this.playVoiceText('¡Bienvenido a PEDKIDS! Comenzando tu aventura educativa');
            
            setTimeout(() => {
                const params = new URLSearchParams({
                    student_id: student.id,
                    grade: this.currentGrade,
                    group: this.currentGroup,
                    username: username
                });
                window.location.href = `/asignaturas/${this.currentGrade}?${params.toString()}`;
            }, 1000);
        } else {
            this.playVoiceText('Usuario o contraseña incorrectos');
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        modal.style.display = 'none';
        
        // Resetear estado
        if (modalId === 'characterModal') {
            this.resetCharacterModal();
        } else if (modalId === 'loginModal') {
            this.resetLoginModal();
        }
    }

    resetCharacterModal() {
        this.currentStudent = null;
        this.selectedCharacter = null;
        this.selectedFigures = [];
        
        document.getElementById('characterSelection').style.display = 'grid';
        document.getElementById('selectedCharacterDisplay').style.display = 'none';
        document.getElementById('passwordSection').style.display = 'none';
        document.getElementById('enterBtn').disabled = true;
        
        // Limpiar cuadritos de contraseña
        const passwordTexts = document.querySelectorAll('.password-text');
        passwordTexts.forEach(text => {
            text.textContent = '';
            text.style.backgroundColor = '#FFF';
            text.style.border = '2px solid #E0E0E0';
        });
        
        document.querySelectorAll('.figure-card').forEach(c => c.classList.remove('selected'));
        
        document.getElementById('characterModalTitle').textContent = '🎭 ¡Selecciona tu personaje!';
        document.getElementById('characterModalDesc').textContent = 'Elige el personaje con el que quieres aprender';
    }

    resetLoginModal() {
        document.getElementById('username').value = '';
        document.getElementById('password').value = '';
    }

    playVoiceText(text) {
        if (!this.voiceEnabled) return;
        
        speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'es-ES';
        utterance.rate = 0.8;
        utterance.pitch = 1.2;
        utterance.volume = 0.8;
        
        speechSynthesis.speak(utterance);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.pedkidsLogin = new PedkidsLogin();
});
