<?php

use yii\db\Migration;

class m170315_082837_create_initial_tables extends Migration
{
    public function up()
    {
        //Create quiz table
        $this->createTable('qm_quiz', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(50)->notNull()->unique(),
            'owner_id' => $this->integer(11)->notNull(),
            'public' => $this->boolean()->notNull()->defaultValue(false),
            'cd' => $this->dateTime()->notNull(),
            'lud' => $this->dateTime()->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        //Add index for quiz on owner_id
        $this->createIndex(
            'idx_quiz_owner_id',
            'qm_quiz',
            'owner_id'
        );

        //Create question table
        $this->createTable('qm_question', [
            'id' => $this->primaryKey(11),
            'text' => $this->string(255)->notNull()->unique(),
            'owner_id' => $this->integer(11)->notNull(),
            'cd' => $this->dateTime()->notNull(),
            'lud' => $this->dateTime()->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        //Add index for question on owner_id
        $this->createIndex(
            'idx-question-owner_id',
            'qm_question',
            'owner_id'
        );

        //Create question_x_quiz table
        $this->createTable('qm_question_x_quiz', [
            'id' => $this->primaryKey(11),
            'question_id' => $this->integer(11)->notNull(),
            'quiz_id' => $this->integer(11)->notNull(),
        ]);

        //Add index for question_x_quiz on quiz_id
        $this->createIndex(
            'idx-question_x_quiz-quiz_id',
            'qm_question_x_quiz',
            'quiz_id'
        );

        //Add foreign keys for relations between question_x_quiz, quiz and question
        $this->addForeignKey('fk-quiz_id', 'qm_question_x_quiz', 'quiz_id', 'qm_quiz', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_id', 'qm_question_x_quiz', 'question_id', 'qm_question', 'id', 'CASCADE', 'CASCADE');

        //Create answer table
        $this->createTable('qm_answer', [
            'id' => $this->primaryKey(11),
            'text' => $this->string(50)->notNull()->unique(),
            'owner_id' => $this->integer(11)->notNull(),
            'cd' => $this->dateTime()->notNull(),
            'lud' => $this->dateTime()->notNull(),
        ]);

        //Add index for answer on owner_id
        $this->createIndex(
            'idx-answer-owner_id',
            'qm_answer',
            'owner_id'
        );

        //Create answer_x_question table
        $this->createTable('qm_answer_x_question', [
            'id' => $this->primaryKey(11),
            'answer_id' => $this->integer(11)->notNull(),
            'question_id' => $this->integer(11)->notNull()
        ]);

        //Add index for answer_x_question on question_id
        $this->createIndex(
            'idx-answer_x_question-question_id',
            'qm_answer_x_question',
            'question_id'
        );

        //Add foreign keys for relations between answer_x_question, question and answer
        $this->addForeignKey('fk-question_id', 'qm_answer_x_question', 'question_id', 'qm_question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-answer_id', 'qm_answer_x_question', 'answer_id', 'qm_answer', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m170315_082837_create_initial_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
