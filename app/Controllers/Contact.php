<?php

namespace App\Controllers;

use App\Models\MessageModel;

class Contact extends BaseController
{
	public function sendMessage()
	{
		// 폼 헬퍼 로드
		helper(['form']);

		// 요청이 POST인지 확인
		if ($this->request->getMethod() === 'post') {
			// 연락 방법 가져오기
			$contactMethod = $this->request->getPost('contact_method');

			// 기존의 유효성 검사 규칙
			$validationRules = [
				'name' => 'required|min_length[2]|max_length[50]',
				'message' => 'required|min_length[10]|max_length[1000]',
				'contact_method' => 'required|in_list[email,phone]',
			];

			// 연락 방법에 따른 추가 유효성 검사
			if ($contactMethod === 'email') {
				$validationRules['email'] = 'required|valid_email|max_length[100]';
			} elseif ($contactMethod === 'phone') {
				$validationRules['phone'] = 'required|min_length[10]|max_length[15]|numeric';
			} else {
				// 연락 방법이 유효하지 않으면 오류 처리
				return redirect()->back()->withInput()->with('error', '올바른 연락 방법을 선택해주세요.');
			}

			$validationMessages = [
				'message' => [
					'min_length' => '메시지는 최소 {param}자 이상 입력해야 합니다.',
					'required' => '메시지를 입력해 주세요.',
				],
				// 다른 필드에 대한 메시지도 추가 가능
			];

			// 유효성 검사 실행 시 메시지 배열을 함께 전달
			if (!$this->validate($validationRules, $validationMessages)) {
				// 유효성 검사 실패 시 처리
				return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
			} else {
				// 유효성 검사 성공 시, 메시지 저장

				// 폼 데이터 가져오기
				$name = $this->request->getPost('name');
				$messageContent = $this->request->getPost('message');
				$contactInfo = '';
				if ($contactMethod === 'email') {
					$contactInfo = $this->request->getPost('email');
				} elseif ($contactMethod === 'phone') {
					$contactInfo = $this->request->getPost('phone');
				}

				// 메시지 모델 로드
				$messageModel = new MessageModel();

				// 데이터 배열 생성
				$data = [
					'name' => $name,
					'contact_method' => $contactMethod,
					'contact_info' => $contactInfo,
					'message' => $messageContent,
				];

				// 데이터베이스에 메시지 저장
				if ($messageModel->save($data)) {
					// 저장 성공 시
					return redirect()->to('/contact')->with('success', '메시지가 성공적으로 전송되었습니다.');
				} else {
					// 저장 실패 시
					return redirect()->back()->withInput()->with('error', '메시지 저장 중 문제가 발생했습니다. 나중에 다시 시도해주세요.');
				}
			}
		} else {
			// POST 요청이 아닌 경우 연락처 페이지로 리디렉션
			return redirect()->to('/contact');
		}
	}
}
