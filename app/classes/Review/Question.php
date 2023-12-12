<?php

namespace Review;

use \DB;
use DynamicProperties;

class Question {

	use DynamicProperties;

	private $areaId;
	private $dbdata;

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
			$this->dbdata = $data;
			$this->areaId = $this->dbdata['areaId'];
			$this->slug = $this->dbdata['slug'];
			$this->text = $this->dbdata['text'];
			$this->type = $this->dbdata['type'];
			$this->multiple = $this->dbdata['multiple'];
			$this->optional = $this->dbdata['optional'];
			$this->grouppedBy = $this->dbdata['grouppedBy'];
		}
	}

	private function getFullSlug() {
		return 's' . $this->areaId . 'd' . $this->slug;
	}

	private function getHasLegend() {
		return (bool) $this->dbdata['rows'];
	}

	private function getGridHeader() {
		$header = explode(',', $this->dbdata['gridHeader']);

		return $header;
	}

	private function getRows() {
		$rows = [];

		switch ($this->type) {
			case 'list':
				// list
				$rowTitles = explode(',', $this->dbdata['rows']);

				foreach ($rowTitles as $rowKey => $rowTitle) {
					$row = [];
					$row['title'] = $rowTitle;
					$row['value'] = $this->multiple ? 1 : $rowKey + 1;
					$row['name'] = $this->multiple ? $this->fullSlug . '_' . ($rowKey + 1) : $this->fullSlug;

					$rows[] = $row;
				}

				break;

			case 'grid':
				if ($this->dbdata['rows']) {
					// multiple rows with legend
					$rowTitles = explode(',', $this->dbdata['rows']);

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
