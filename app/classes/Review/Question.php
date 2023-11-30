<?php

namespace Review;

use \DB;

class Question {
	private $areaId;
	private $data;

	public $id;
	public $text;
	public $type;
	public $slug;
	public $multiple;
	public $optional;
	public $grouppedBy;

	function __construct($id) {
		if ($data = DB::row('* FROM review_questions WHERE id=?', [$id])) {
			$this->id = $id;
			$this->data = $data;
			$this->areaId = $this->data['areaId'];
			$this->slug = $this->data['slug'];
			$this->text = $this->data['text'];
			$this->type = $this->data['type'];
			$this->multiple = $this->data['multiple'];
			$this->optional = $this->data['optional'];
			$this->grouppedBy = $this->data['grouppedBy'];
		}
	}

	function __get($name) {
		switch ($name) {
			case 'fullSlug':
				return $this->fullSlug = 's' . $this->areaId . 'd' . $this->slug;

				// structure
			case 'gridHeader':
				return $this->gridHeader = $this->getGridHeader();
			case 'rows':
				return $this->rows = $this->getRows();
			case 'hasLegend':
				return $this->hasLegend = (bool) $this->data['rows'];

				// answers
			case 'answers':
				return $this->answers = $this->getAnswers();
		}
	}

	private function getGridHeader() {
		$header = explode(',', $this->data['gridHeader']);

		return $header;
	}

	private function getRows() {
		$rows = [];

		switch ($this->type) {
			case 'list':
				// list
				$rowTitles = explode(',', $this->data['rows']);

				foreach ($rowTitles as $rowKey => $rowTitle) {
					$row = [];
					$row['title'] = $rowTitle;
					$row['value'] = $this->multiple ? 1 : $rowKey + 1;
					$row['name'] = $this->multiple ? $this->fullSlug . '_' . ($rowKey + 1) : $this->fullSlug;

					$rows[] = $row;
				}

				break;

			case 'grid':
				if ($this->data['rows']) {
					// multiple rows with legend
					$rowTitles = explode(',', $this->data['rows']);

					foreach ($rowTitles as $rowKey => $rowTitle) {
						$row = [];
						$row['title'] = $rowTitle;
						$row['content'] = [];

						foreach ($this->gridHeader as $headerKey => $_looping) {
							$row['content'][] = [
								'value' => $this->grouppedBy == 'rows' ? $headerKey + 1 : $rowKey + 1,
								'name' => $this->grouppedBy == 'rows' ? $this->fullSlug . '_' . ($rowKey + 1) :  $this->fullSlug . '_' . ($headerKey + 1)
							];
						}

						$rows[] = $row;
					}
				} else {
					// single row
					$row['content'] = [];

					foreach ($this->gridHeader as $key => $_looping) {
						$row['content'][] = [
							'value' => $key + 1,
							'name' => $this->fullSlug
						];
					}

					$rows[] = $row;
				}

				break;
		}

		return $rows;
	}

	private function getAnswers() {
		$answers = [];

		if ($this->type == 'grid' && $this->grouppedBy == 'rows') {
			// answers for grids groupped by rows
			$rawAnswers = $this->rows[0]['content'];

			foreach ($rawAnswers as $answerId => $_looping) {
				$answers[] = $this->gridHeader[$answerId];
			}
		} else {
			// answers for lists or grids groupped by columns
			$rawAnswers = $this->rows;

			foreach ($rawAnswers as $answer) {
				$answers[] = $answer['title'];
			}
		}

		return $answers;
	}
}
