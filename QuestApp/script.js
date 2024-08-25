// DOM ELEMENTS
const adminPanelButton = document.getElementById('admin_panel');
const listQuestionsButton = document.getElementById('list_questions');
const mainContainer = document.getElementById('main_container');

let questions = [
  {
    question: "Türkiye'nin başkenti neresidir?",
    answers: {
      A: ['Paris', false],
      B: ['Adana', false],
      C: ['Ankara', true],
      D: ['Kastamonu', false],
    },
    difficulty: 1,
  },
  {
    question: 'En büyük okyanus hangisidir?',
    answers: {
      A: ['Atlantik Okyanusu', false],
      B: ['Hint Okyanusu', false],
      C: ['Arktik Okyanusu', false],
      D: ['Pasifik Okyanusu', true],
    },
    difficulty: 3,
  },
  {
    question: 'Dünyanın en yüksek dağı hangisidir?',
    answers: {
      A: ['K2', false],
      B: ['Kangchenjunga', false],
      C: ['Everest', true],
      D: ['Lhotse', false],
    },
    difficulty: 5,
  },
  {
    question: 'Python programlama dilinin yaratıcısı kimdir?',
    answers: {
      A: ['Guido van Rossum', true],
      B: ['Dennis Ritchie', false],
      C: ['James Gosling', false],
      D: ['Bjarne Stroustrup', false],
    },
    difficulty: 8,
  },
  {
    question: 'Türkiye’nin en uzun nehri hangisidir?',
    answers: {
      A: ['Kızılırmak', true],
      B: ['Fırat Nehri', false],
      C: ['Dicle Nehri', false],
      D: ['Yeşilırmak', false],
    },
    difficulty: 1,
  },
];

if (adminPanelButton) {
  adminPanelButton.addEventListener('click', () => {
    loadAdminPanel();
  });
}

if (listQuestionsButton) {
  listQuestionsButton.addEventListener('click', () => {
    loadQuestionsList();
  });
}

const loadAddQuestionPage = () => {
  mainContainer.innerHTML = '';

  const backButton = document.createElement('button');
  backButton.classList.add('back-button');
  backButton.textContent = 'Geri';
  backButton.onclick = () => loadAdminPanel();

  mainContainer.appendChild(backButton);

  const header = document.createElement('h3');
  header.textContent = 'Soru Ekleme Sayfası';

  mainContainer.appendChild(header);

  const soruForm = document.createElement('form');
  soruForm.id = 'soru_form';

  const soruInput = document.createElement('textarea');
  soruInput.classList.add('text-input');
  soruInput.type = 'text';
  soruInput.placeholder = 'Soru giriniz';
  soruInput.required = true;

  soruForm.appendChild(soruInput);

  const answerA = document.createElement('input');
  answerA.classList.add('text-input');
  answerA.type = 'text';
  answerA.placeholder = 'A şıkkını giriniz';
  answerA.required = true;

  const answerB = document.createElement('input');
  answerB.classList.add('text-input');
  answerB.type = 'text';
  answerB.placeholder = 'B şıkkını giriniz';
  answerB.required = true;

  const answerC = document.createElement('input');
  answerC.classList.add('text-input');
  answerC.type = 'text';
  answerC.placeholder = 'C şıkkını giriniz';
  answerC.required = true;

  const answerD = document.createElement('input');
  answerD.classList.add('text-input');
  answerD.type = 'text';
  answerD.placeholder = 'D şıkkını giriniz';
  answerD.required = true;

  soruForm.appendChild(answerA);
  soruForm.appendChild(answerB);
  soruForm.appendChild(answerC);
  soruForm.appendChild(answerD);

  const difficultyInput = document.createElement('input');
  difficultyInput.classList.add('text-input');
  difficultyInput.type = 'number';
  difficultyInput.placeholder = 'Zorluk seviyesini giriniz';
  difficultyInput.required = true;

  soruForm.appendChild(difficultyInput);

  const trueAnswerLabel = document.createElement('label');
  trueAnswerLabel.textContent = 'Doğru cevap:';
  const trueAnswer = document.createElement('select');
  trueAnswer.classList.add('text-input');

  const answerSelectorA = document.createElement('option');
  answerSelectorA.value = 'A';
  answerSelectorA.textContent = 'A';
  trueAnswer.appendChild(answerSelectorA);

  const answerSelectorB = document.createElement('option');
  answerSelectorB.value = 'B';
  answerSelectorB.textContent = 'B';
  trueAnswer.appendChild(answerSelectorB);

  const answerSelectorC = document.createElement('option');
  answerSelectorC.value = 'C';
  answerSelectorC.textContent = 'C';
  trueAnswer.appendChild(answerSelectorC);

  const answerSelectorD = document.createElement('option');
  answerSelectorD.value = 'D';
  answerSelectorD.textContent = 'D';
  trueAnswer.appendChild(answerSelectorD);

  soruForm.appendChild(trueAnswerLabel);
  soruForm.appendChild(trueAnswer);

  const addButton = document.createElement('button');
  addButton.classList.add('bottom-button');
  addButton.textContent = 'Ekle';
  addButton.type = 'submit';

  soruForm.appendChild(addButton);

  soruForm.addEventListener('submit', (event) => {
    event.preventDefault();
    addQuestion(
      soruInput.value,
      answerA.value,
      answerB.value,
      answerC.value,
      answerD.value,
      difficultyInput.value,
      trueAnswer.value
    );
  });

  mainContainer.appendChild(soruForm);
};

const loadEditQuestionPage = (index) => {
  const question = questions[index];

  mainContainer.innerHTML = '';

  const backButton = document.createElement('button');
  backButton.classList.add('back-button');
  backButton.textContent = 'Geri';
  backButton.onclick = () => loadAdminPanel();

  mainContainer.appendChild(backButton);

  const header = document.createElement('h3');
  header.textContent = 'Soru Düzenleme Sayfası';

  mainContainer.appendChild(header);

  const soruForm = document.createElement('form');
  soruForm.id = 'soru_form';

  const soruInput = document.createElement('textarea');
  soruInput.classList.add('text-input');
  soruInput.type = 'text';
  soruInput.placeholder = 'Soru giriniz';
  soruInput.required = true;
  soruInput.value = question.question;

  soruForm.appendChild(soruInput);

  const answerA = document.createElement('input');
  answerA.classList.add('text-input');
  answerA.type = 'text';
  answerA.placeholder = 'A şıkkını giriniz';
  answerA.required = true;
  answerA.value = question.answers.A[0];

  const answerB = document.createElement('input');
  answerB.classList.add('text-input');
  answerB.type = 'text';
  answerB.placeholder = 'B şıkkını giriniz';
  answerB.required = true;
  answerB.value = question.answers.B[0];

  const answerC = document.createElement('input');
  answerC.classList.add('text-input');
  answerC.type = 'text';
  answerC.placeholder = 'C şıkkını giriniz';
  answerC.required = true;
  answerC.value = question.answers.C[0];

  const answerD = document.createElement('input');
  answerD.classList.add('text-input');
  answerD.type = 'text';
  answerD.placeholder = 'D şıkkını giriniz';
  answerD.required = true;
  answerD.value = question.answers.D[0];

  soruForm.appendChild(answerA);
  soruForm.appendChild(answerB);
  soruForm.appendChild(answerC);
  soruForm.appendChild(answerD);

  const difficultyInput = document.createElement('input');
  difficultyInput.classList.add('text-input');
  difficultyInput.type = 'number';
  difficultyInput.placeholder = 'Zorluk seviyesini giriniz';
  difficultyInput.required = true;
  difficultyInput.value = question.difficulty;

  const trueAnswerLabel = document.createElement('label');
  trueAnswerLabel.textContent = 'Doğru cevap:';
  const trueAnswer = document.createElement('select');
  trueAnswer.classList.add('text-input');

  const answerSelectorA = document.createElement('option');
  answerSelectorA.value = 'A';
  answerSelectorA.textContent = 'A';
  trueAnswer.appendChild(answerSelectorA);

  const answerSelectorB = document.createElement('option');
  answerSelectorB.value = 'B';
  answerSelectorB.textContent = 'B';
  trueAnswer.appendChild(answerSelectorB);

  const answerSelectorC = document.createElement('option');
  answerSelectorC.value = 'C';
  answerSelectorC.textContent = 'C';
  trueAnswer.appendChild(answerSelectorC);

  const answerSelectorD = document.createElement('option');
  answerSelectorD.value = 'D';
  answerSelectorD.textContent = 'D';
  trueAnswer.appendChild(answerSelectorD);

  let i = 0;
  for (let key in question.answers) {
    const answer = question.answers[key];

    if (answer[1]) {
      trueAnswer[i].selected = true;
    }
    i++;
  }
  soruForm.appendChild(difficultyInput);
  soruForm.appendChild(trueAnswerLabel);
  soruForm.appendChild(trueAnswer);

  const addButton = document.createElement('button');
  addButton.classList.add('bottom-button');
  addButton.textContent = 'Kaydet';
  addButton.type = 'submit';

  soruForm.appendChild(addButton);

  soruForm.addEventListener('submit', (event) => {
    event.preventDefault();

    questions[index] = {
      question: soruInput.value,
      answers: {
        A: [answerA.value, false],
        B: [answerB.value, false],
        C: [answerC.value, false],
        D: [answerD.value, false],
      },
      difficulty: parseInt(difficultyInput.value, 10),
    };

    questions[index].answers[trueAnswer.value][1] = true;

    loadAdminPanel();
  });

  mainContainer.appendChild(soruForm);
};

const loadSearchResults = (query) => {
  let searchResults = [];

  questions.forEach((value, index) => {
    if (value.question.toLowerCase().includes(query.toLowerCase())) {
      value.realIndex = index;
      searchResults.push(value);
    }
  });

  mainContainer.innerHTML = '';

  const backButton = document.createElement('button');
  backButton.classList.add('back-button');
  backButton.textContent = 'Geri';
  backButton.onclick = () => loadAdminPanel();

  mainContainer.appendChild(backButton);

  const header = document.createElement('h3');
  header.textContent = 'Arama Sonuçları';

  mainContainer.appendChild(header);

  if (searchResults.length === 0) {
    const result = document.createElement('h4');
    result.textContent = 'Sonuç Bulunamadı!';

    mainContainer.appendChild(result);
  }

  const questionList = document.createElement('div');
  questionList.classList.add('question-list');
  questionList.id = 'question_list';

  searchResults.forEach((value, index) => {
    let questionText =
      value.question.length > 30
        ? value.question.slice(0, 30) + '...'
        : value.question;

    const question = document.createElement('div');
    question.classList.add('container', 'question');
    question.textContent = questionText;

    const editButton = document.createElement('button');
    editButton.classList.add('admin-panel-question-button');
    editButton.textContent = 'Düzenle';
    editButton.onclick = () => loadEditQuestionPage(value.realIndex);
    question.appendChild(editButton);

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('admin-panel-question-button');
    deleteButton.textContent = 'Sil';
    deleteButton.onclick = () => deleteQuestion(value.realIndex);
    question.appendChild(deleteButton);

    questionList.appendChild(question);
  });

  mainContainer.appendChild(questionList);
};

const loadAdminPanel = () => {
  mainContainer.innerHTML = '';

  const backButton = document.createElement('button');
  backButton.classList.add('back-button');
  backButton.textContent = 'Geri';
  backButton.onclick = () => loadMainPage();

  mainContainer.appendChild(backButton);

  const searchBar = document.createElement('input');
  searchBar.type = 'text';
  searchBar.id = 'search_bar';
  searchBar.placeholder = 'Soru Ara';
  searchBar.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
      loadSearchResults(searchBar.value);
    }
  });

  mainContainer.appendChild(searchBar);

  const questionList = document.createElement('div');
  questionList.classList.add('question-list');
  questionList.id = 'question_list';

  questions.forEach((value, index) => {
    let questionText =
      value.question.length > 30
        ? value.question.slice(0, 30) + '...'
        : value.question;

    const question = document.createElement('div');
    question.classList.add('container', 'question');
    question.textContent = questionText;

    const editButton = document.createElement('button');
    editButton.classList.add('admin-panel-question-button');
    editButton.textContent = 'Düzenle';
    editButton.onclick = () => loadEditQuestionPage(index);
    question.appendChild(editButton);

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('admin-panel-question-button');
    deleteButton.textContent = 'Sil';
    deleteButton.onclick = () => deleteQuestion(index);
    question.appendChild(deleteButton);

    questionList.appendChild(question);
  });

  mainContainer.appendChild(questionList);

  const addQuestionButton = document.createElement('button');
  addQuestionButton.classList.add('bottom-button');
  addQuestionButton.textContent = 'Soru Ekle';
  addQuestionButton.onclick = () => loadAddQuestionPage();

  mainContainer.appendChild(addQuestionButton);
};

const deleteQuestion = (index) => {
  questions = questions.filter((value, i) => {
    return i !== index;
  });

  loadAdminPanel();
};

const addQuestion = (
  soruText,
  answerA,
  answerB,
  answerC,
  answerD,
  difficulty,
  trueAnswer
) => {
  const questionObject = {
    question: soruText,
    answers: {
      A: [answerA, false],
      B: [answerB, false],
      C: [answerC, false],
      D: [answerD, false],
    },
    difficulty: parseInt(difficulty, 10),
  };

  questionObject.answers[trueAnswer][1] = true;

  questions.push(questionObject);

  loadAdminPanel();
};

const loadMainPage = () => {
  mainContainer.innerHTML = '';
  mainContainer.appendChild(adminPanelButton);
  mainContainer.appendChild(listQuestionsButton);
};

const loadQuestionsList = () => {
  const randomizedArray = shuffle([...questions]);
  mainContainer.innerHTML = '';

  let currentQuestionIndex = 0;
  let score = 0;
  let trueAnswerNumber = 0;

  const questionsElement = document.createElement('div');
  questionsElement.classList.add('container', 'inner-container');
  const optionsElement = document.createElement('div');
  optionsElement.classList.add('options-element');

  mainContainer.appendChild(questionsElement);
  mainContainer.appendChild(optionsElement);

  const displayQuestion = () => {
    questionsElement.innerHTML = '';
    const currentQuestion = randomizedArray[currentQuestionIndex];
    const questionTextElement = document.createElement('h4');
    questionTextElement.textContent = currentQuestion.question;
    questionsElement.appendChild(questionTextElement);
    optionsElement.innerHTML = '';

    for (let key in currentQuestion.answers) {
      const button = document.createElement('button');
      button.classList.add('option-button');
      button.textContent = currentQuestion.answers[key][0];
      button.addEventListener('click', () => checkAnswer(key));
      optionsElement.appendChild(button);
    }
  };
  mainContainer.appendChild(optionsElement);

  const checkAnswer = (key) => {
    const currentQuestion = randomizedArray[currentQuestionIndex];
    if (currentQuestion.answers[key][1]) {
      score += currentQuestion.difficulty;
      trueAnswerNumber++;
    }

    currentQuestionIndex++;

    if (currentQuestionIndex < randomizedArray.length) {
      displayQuestion();
    } else {
      showResult();
    }
  };

  const showResult = () => {
    mainContainer.innerHTML = '';

    const backButton = document.createElement('button');
    backButton.classList.add('back-button');
    backButton.textContent = 'Geri';
    backButton.onclick = () => loadMainPage();
    mainContainer.appendChild(backButton);

    const resultBlock = document.createElement('div');
    const result = document.createElement('h3');
    result.textContent = `${randomizedArray.length} sorudan ${trueAnswerNumber} tanesini doğru cevapladınız.`;
    const scoreText = document.createElement('h4');
    scoreText.textContent = `Skorunuz: ${score}`;

    resultBlock.appendChild(result);
    resultBlock.appendChild(scoreText);

    mainContainer.appendChild(resultBlock);
  };

  displayQuestion();
};

const shuffle = (array) => {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
};
